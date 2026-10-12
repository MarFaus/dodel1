<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Reader;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $a1 = Author::create([
            'name' => 'Александр Пушкин',
            'birth_date' => '1799-06-06',
            'country' => 'Россия',
            'biography' => 'Великий русский поэт, драматург и прозаик.'
        ]);

        $a2 = Author::create([
            'name' => 'Лев Толстой',
            'birth_date' => '1828-09-09',
            'country' => 'Россия',
            'biography' => 'Один из наиболее известных классиков мировой литературы.'
        ]);

        $a3 = Author::create([
            'name' => 'Джоан Роулинг',
            'birth_date' => '1965-07-31',
            'country' => 'Великобритания',
            'biography' => 'Британская писательница, автор серии романов о Гарри Поттере.'
        ]);

        $a4 = Author::create([
            'name' => 'Жюль Верн',
            'birth_date' => '1828-02-08',
            'country' => 'Франция',
            'biography' => 'Французский писатель, классик приключенческой литературы.'
        ]);

        $b1 = Book::create([
            'title' => 'Евгений Онегин',
            'author_id' => $a1->id,
            'genre' => 'Роман в стихах',
            'year' => 1833,
            'isbn' => '978-5-389-01234-1',
            'quantity' => 5,
            'available' => true,
            'description' => 'Роман в стихах Александра Сергеевича Пушкина.'
        ]);

        $b2 = Book::create([
            'title' => 'Капитанская дочка',
            'author_id' => $a1->id,
            'genre' => 'Исторический роман',
            'year' => 1836,
            'isbn' => '978-5-389-01235-8',
            'quantity' => 3,
            'available' => true,
            'description' => 'Исторический роман о событиях крестьянского восстания.'
        ]);

        $b3 = Book::create([
            'title' => 'Война и мир',
            'author_id' => $a2->id,
            'genre' => 'Роман-эпопея',
            'year' => 1869,
            'isbn' => '978-5-389-01236-5',
            'quantity' => 4,
            'available' => true,
            'description' => 'Роман-эпопея Льва Николаевича Толстого.'
        ]);

        $b4 = Book::create([
            'title' => 'Гарри Поттер и философский камень',
            'author_id' => $a3->id,
            'genre' => 'Фэнтези',
            'year' => 1997,
            'isbn' => '978-5-389-01237-2',
            'quantity' => 5,
            'available' => true,
            'description' => 'Первая книга серии о юном волшебнике Гарри Поттере.'
        ]);

        $b5 = Book::create([
            'title' => 'Пятнадцатилетний капитан',
            'author_id' => $a4->id,
            'genre' => 'Приключения',
            'year' => 1878,
            'isbn' => '978-5-389-01238-9',
            'quantity' => 2,
            'available' => true,
            'description' => 'Приключенческий роман Жюля Верна.'
        ]);

        $r1 = Reader::create([
            'full_name' => 'Иванов Иван Иванович',
            'phone' => '+7 700 111 22 33',
            'email' => 'ivanov@example.com',
            'birth_date' => '2001-05-15',
        ]);

        $r2 = Reader::create([
            'full_name' => 'Петров Петр Сергеевич',
            'phone' => '+7 701 222 33 44',
            'email' => 'petrov@example.com',
            'birth_date' => '1999-08-20',
        ]);

        $r3 = Reader::create([
            'full_name' => 'Сидорова Анна Владимировна',
            'phone' => '+7 702 333 44 55',
            'email' => 'sidorova@example.com',
            'birth_date' => '2003-12-10',
        ]);

        Borrowing::create([
            'book_id' => $b4->id,
            'reader_id' => $r1->id,
            'borrowed_at' => now()->subDays(5)->toDateString(),
            'return_date' => now()->addDays(9)->toDateString(),
            'status' => 'borrowed',
        ]);

        Borrowing::create([
            'book_id' => $b1->id,
            'reader_id' => $r2->id,
            'borrowed_at' => now()->subDays(10)->toDateString(),
            'return_date' => now()->subDays(2)->toDateString(),
            'returned_at' => now()->subDays(1)->toDateString(),
            'status' => 'returned',
        ]);
    }
}