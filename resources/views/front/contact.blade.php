@extends('layouts.front')

@section('title', 'Contact')

@section('content')

    <div class="max-w-xl mx-auto bg-white rounded-xl border border-slate-200 shadow-sm p-6">

        <h1 class="text-2xl font-bold text-slate-900 mb-4">Contact Us</h1>
        <p class="text-sm text-slate-500 mb-6">Send us a message and we will get back to you.</p>

        <form method="POST" action="{{ route('contact.store') }}">
            @csrf

            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-slate-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-slate-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Message</label>
                <textarea name="message" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg" required></textarea>
            </div>

            <button class="px-5 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                Send Message
            </button>
        </form>

    </div>

@endsection
