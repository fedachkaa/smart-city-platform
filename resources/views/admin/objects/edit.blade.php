@extends('layouts.app')

@section('content')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
            <a href="{{ route('dashboard.objects.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                ← Back to List
            </a>
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Edit Infrastructure Object
            </h1>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('dashboard.objects.update', $object) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.objects.form', ['buttonText' => 'Update Changes'])
                </form>
            </div>
        </div>
    </main>
@endsection