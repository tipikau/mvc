<?php

namespace Controller;

use Model\Book;
use Model\Book_reader;
use Model\Reader;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class ReaderView
{
    public function reader_list(Request $request): string
    {
        if ($request->method === "POST") {
            if (Reader::where('reader_id', 'like', '%' . $request->search . '%')->get()) {
                $result = Reader::where('reader_id', 'like', '%' . $request->search . '%');
            } else if (Reader::where('fio', '%' . $request->search . '%')->get()) {
                $result = Reader::where('fio', '%' . $request->search . '%')->get();
            }
        } else {
            $result = Reader::orderBy('fio')->get();
        }

        return (new View())->render('site.reader.readers', ['reader_list' => $result]);
    }

    public function reader(Request $request): string
    {
        $fio = Reader::where('reader_id', $request->id)->get('fio');
        if (Book_reader::where('reader_id', $request->id)->exists()) {
            $result = Book_reader::where('book_readers.reader_id', $request->id)
                ->join('books', 'books.book_id', '=', 'book_readers.book_id')
                ->where('book_readers.reader_id', $request->id)
                ->join('readers', 'readers.reader_id', '=', 'book_readers.reader_id')
                ->orderBy('date_issue')
                ->get();
        } else {
            $result = null;
        }
        return (new View())->render('site.reader.reader', ['info' => $result, 'fio' => $fio, 'id' => $request->id]);
    }

    public function reader_add(Request $request): string
    {
        $validator = new Validator($request->all(), [
            'fio' => ['required'],
            'adress' => ['required'],
            'phone_number' => ['required']
        ], [
            'required' => 'Поле :field пусто',
        ]);
        if ($validator->fails()) {
            $message = json_encode($validator->errors(), JSON_UNESCAPED_UNICODE);
            return new View('site.reader.reader_add', ['errors' => $message]);
        }

        if ($request->method === 'POST' && Reader::create($request->all())) {
            app()->route->redirect('/readers');
        }
        return new View('site.reader.reader_add');
    }

    public function book_reader(Request $request): string
    {
        $err = null;
        if ($request->method === "POST" && Book_reader::whereNot('book_id', $request->book_id)->where('reader_id', $request->id)->exists()) {
            if (Book_reader::create([
                'book_id' => $request->book_id,
                'reader_id' => $request->id,
                'date_issue' => date('Y-m-d'),
                'librarian_id ' => Auth::user()->id
            ])) {
                app()->route->redirect('/readers');
            }
        } else {
            $err = 'Эта книга уже выдана';
        }
        $date_issue = Book_reader::where('reader_id', $request->id)->get('date_issue');
        $book = Book::where('book_id', $request->id)->get('name');
        $book_list = Book::orderBy('name')->get();
        return (new View())->render('site.reader.reader_book', ['book_list' => $book_list, 'date_issue' => $date_issue, 'book' => $book, 'error' => $err]);
    }
}
