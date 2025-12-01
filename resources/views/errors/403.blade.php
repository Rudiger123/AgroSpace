@extends('errors.layout')

@section('title', __('errors.403.title'))
@section('code', '403')
@section('message', __('errors.403.message'))
@section('description', __('errors.403.description'))

@section('image')
    <!-- SVG Padlock / Fence -->
    <svg class="w-48 h-32 mx-auto text-[#FFB300]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" fill="#F5F5DC" />
        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        <path d="M12 15v2" stroke="#37474F" stroke-width="2"/>
    </svg>
@endsection