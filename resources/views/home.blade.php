@extends('layouts.public')

@section('title', ($company?->company_name ?? 'Magnetic Power Battery') . ' — Lithium-ion Battery Manufacturer')
@section('meta_description', $company?->tagline ?? 'Professional Lithium-ion Battery Manufacturer specializing in LFP and NMC battery technologies for electric mobility and energy storage.')

@section('content')

    <h1>homepage</h1>
@endsection
