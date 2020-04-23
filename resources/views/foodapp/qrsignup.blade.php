<?php

//	use Endroid\QrCode\QrCode;
//	$qrCode = new QrCode('Life is too short to be generating QR codes');

use chillerlan\QRCode\QRCode;

$qrOptions = new \chillerlan\QRCode\QROptions(
	[
		'version'  => 5,
		'eccLevel' => QRCode::ECC_L
	]
);

?>
@extends('voyager::master')

@section('page_header')
	<h1 class="page-title">
		<i class="voyager-phone"></i>
		Study: {{ $study->name }}
	</h1>
@stop

@section('content')
	<div class="page-content container-fluid center-block">
		@include('voyager::alerts')


		@unless ($study->reg_public)
			<div class="alert alert-warning" role="alert">Study signup is not set to public - users can not signup from within the app</div>
		@endunless

		@if ( $study->reg_limit && $study->user_count >= $study->reg_limit )
			<div class="alert alert-warning" role="alert">Signup limit has been reached</div>
		@endunless

		@if ( $study->until && date_create() >= date_create($study->until) )
			<div class="alert alert-warning" role="alert">The study has expired. (The <em>until date </em> is in the past.</div>
		@endunless


		<div class="row">
			<div class="col-sm-12 col-md-6 col-med-centered">
				<div class="panel panel-bordered ">
					<div class="text-center">
						<img src="<?=( new QRCode($qrOptions) )->render($study->reg_key . ':' . $study->reg_pass)?>" alt="QR Code" />
						<p>
							The QR code above needs to be scanned with the app for signing up.
							<br />
							<small>(image can be saved and distributed to users)</small>
						</p>
					</div>

					<div class="">
						<p>
							<strong>key</strong> {{$study->reg_key}}
							<br />
							<strong>pass</strong> {{$study->reg_pass}}
						</p>
					</div>

				</div>
			</div>
		</div>


	</div>
@stop

