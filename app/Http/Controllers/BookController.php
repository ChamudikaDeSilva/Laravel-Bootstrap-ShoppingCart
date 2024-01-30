<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('products', compact('books'));
    }

    public function bookCart()
    {
        return view('cart');
    }
    /*public function addBooktoCart($id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $book->name,
                "quantity" => 1,
                "price" => $book->price,
                "image" => $book->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Book has been added to cart!');
    }*/

    public function addBooktoCart($id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $book->name,
                "quantity" => 1,
                "price" => $book->price,
                "image" => $book->image
            ];
        }

        // Calculate the total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        // Store the total in the session
        session()->put('cart', $cart);
        session()->put('cart_total', $total);

        return redirect()->back()->with('success', 'Book has been added to cart!');
    }


    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Book added to cart.');
        }
    }

    /*public function deleteProduct(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Book successfully deleted.');
        }
    }*/

    public function deleteProduct(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart', []);

            if (isset($cart[$request->id])) {
                // Get the price and quantity of the item being removed
                $price = $cart[$request->id]['price'];
                $quantity = $cart[$request->id]['quantity'];

                // Remove the item from the cart
                unset($cart[$request->id]);

                // Recalculate the total after deleting an item
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['quantity'] * $item['price'];
                }

                // Update the cart and total in the session
                session()->put('cart', $cart);
                session()->put('cart_total', $total);

                session()->flash('success', 'Book successfully deleted.');
            }
        }
    }

    // CheckoutController.php

    public function showCheckout()
    {
        $cartTotal = Session::get('cart_total', 0);

        return view('checkout', ['cartTotal' => $cartTotal]);
    }

}
