@extends('layouts.admin')
@section('contenido')
<!-- Content Header (Page header) -->
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}

            </a>


        </div>

    </nav>
    <div class="container">
        <h2>SISTEMA DE CONTROL DE INVENTARIO Y VENTAS</h2>
        <h2>Autor:Mario Leonardo Yarleque Farfan</h2>
    </div>

</div>

<!-- /.content-header -->

<!-- Hoverable rows start -->

<!-- Hoverable rows end -->
@endSection