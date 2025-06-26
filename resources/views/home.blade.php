@extends('layouts.app')

@section('content')
    <div class="container my-5 text-capitalize">
        <?php $user = Auth::user(); ?>
        @hasanyrole('superadmin')
            
        @endhasanyrole
        @hasanyrole('student')
        
        @endhasanyrole

        @hasanyrole('member')
            
        @endhasanyrole


    </div>
@endsection
