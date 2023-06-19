<?php

namespace Controller;

use Model\Book;
use Model\Book_reader;
use Model\Genre;
use Model\Hall;
use Model\Publisher;
use Momiamgood\Isbn as Isbn;
use Src\Request;
use Src\Validator\Validator;
use Src\View;
use Upload\Storage\FileSystem;

class BookView
{
    public function book_detail(Request $request): string
    {
        if (Book_reader::where('book_id', $request->id)->get()) {
            $result = Book_reader::where('book_readers.book_id', $request->id)
                ->join('books', 'books.book_id', '=', 'book_readers.book_id')
                ->where('book_readers.book_id', $request->id)
                ->join('readers', 'readers.reader_id', '=', 'book_readers.reader_id')
                ->orderBy('date_issue')
                ->get();
        } else {
            $result = null;
        }
        $cover = Book::where('book_id', $request->id)->get('cover');
        $book_id = $request->id;
        $book = Book::where('book_id', $request->id)->get();
        return (new View())->render('site.book.book', ['book' => $book, 'book_id' => $book_id, 'reader_list' => $result, 'cover' => $cover]);
    }

    public function book_list(Request $request): string
    {
        if ($request->method === "POST") {
            $book_list = Book::where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $book_list = Book::orderBy('name')->get();
        }
        return (new View())->render('site.book.books', ['book_list' => $book_list]);
    }


    public function book_add(Request $request): string
    {
        $message = null;

        $hall_list = Hall::all();
        $genre_list = Genre::all();
        $publisher_list = Publisher::all();

        if ($request->method === "POST") {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'author' => ['required'],
                'price' => ['required', 'number'],
                'annotation' => ['required'],
                'date_publish' => ['number']
            ], [
                'required' => 'Поле :field пусто',
                'letter' => 'Поле :field должно содержать только буквы и символы',
                'number' => 'Поле :field должно содержать только цифры'
            ]);
            if ($validator->fails()) {
                $message = json_encode($validator->errors(), JSON_UNESCAPED_UNICODE);
                return new View('site.book.book_add', ['hall_list' => $hall_list,
                    'genre_list' => $genre_list,
                    'publisher_list' => $publisher_list,
                    'errors' => $message]);
            }

            $path = '../public/static/media/covers/';
            $storage = new FileSystem($path);
            $file = new \Upload\File('cover_file', $storage);

            $new_filename = uniqid();
            $file->setName($new_filename);

            $file_name = $file->getNameWithExtension($new_filename);

            try {
                $file->upload();
            } catch (\Exception $e) {
                $errors = $file->getErrors();
            }

            $isbn = new Isbn\Isbn();

            if (Book::create([
                'name' => str($request->name),
                'cover' => str(($path . $file_name)),
                'author' => str($request->author),
                'date_publish' => date($request->date_publish),
                'price' => (int)($request->price),
                'annotation' => str($request->annotation),
                'new' => (bool)$request->new,
                'genre_id' => (int)$request->genre_id,
                'hall_id' => (int)$request->hall_id,
                'publisher_id' => (int)$request->publisher_id,
                'rent' => true,
                'isbn' => $isbn->generateIsbn()

            ])) {
                app()->route->redirect('/books');
            }
        }

        return (new View())->render('site.book.book_add', ['hall_list' => $hall_list,
            'genre_list' => $genre_list,
            'publisher_list' => $publisher_list,
            'errors' => $message]);
    }

    public function book_update(Request $request): string
    {
        $hall_list = Hall::all();
        $genre_list = Genre::all();
        $publisher_list = Publisher::all();
        $book = Book::where('book_id', $request->id)->get();


        if ($request->method == "POST") {

            $path = '../public/static/media/covers/';
            $storage = new FileSystem($path);
            $file = new \Upload\File('cover_file', $storage);

            $new_filename = uniqid();
            $file->setName($new_filename);

            $file_name = $file->getNameWithExtension($new_filename);

            try {
                $file->upload();
            } catch (\Exception $e) {
                $errors = $file->getErrors();
            }

            if (Book::where('book_id', $request->id)->update([
                'name' => str($request->name),
                'cover' => $path . $file_name,
                'author' => str($request->author),
                'date_publish' => date($request->date_publish),
                'price' => (int)($request->price),
                'annotation' => str($request->annotation),
                'new' => (bool)$request->new,
                'genre_id' => (int)$request->genre_id,
                'hall_id' => (int)$request->hall_id,
                'publisher_id' => (int)$request->publisher_id,
                'rent' => true
            ])) {
                app()->route->redirect('/books');
            }
        }
        return (new View())->render('site.book.book_update', ['hall_list' => $hall_list, 'genre_list' => $genre_list, 'publisher_list' => $publisher_list, 'book' => $book]);
    }

    public function delete_book(Request $request): void
    {
        if (Book_reader::where('book_id', $request->id)->get() && Book_reader::where('book_id', $request->id)->delete()) {
            {
                $file = Book::where('book_id', $request->id)->get('cover');
                $path = '../public/static/media/covers/';
                unlink($path . $file);
                if (Book::where('book_id', $request->id)->delete()) {
                    app()->route->redirect('/books');
                }
            }
        } else if (Book::where('book_id', $request->id)->delete()) {
            app()->route->redirect('/books');
        }
    }


}