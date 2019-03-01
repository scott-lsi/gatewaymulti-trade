@extends('emails.master')

@section('title', env('EMAIL_ORDER_SUBJECT'))

@section('content')

<tr>
	<td>
        <p style="font-size:14px; margin-top:30px; margin-bottom:20px;">Hi {{ $name }},</p>
        <p style="font-size:14px; margin-top:30px; margin-bottom:20px;">Thank you for visiting us at {{ env('APP_NAME') }} . Your personalised product will be despatched to you within the next couple of days.</p>
	</td>
</tr>

@foreach($basket as $row)
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" border="0" width="600" align="center">
			<tr>
				<td width="100">
				    <img src="{{ $row->options->imageurl }}" width="80" height="80" alt="{{ $row->name }}">
				</td>
				<td>
					<p style="margin-top:0;margin-bottom:5px;font-size:20px;color:#EC008C;">{{ $row->name }}</p>
					<p style="margin-top:0;margin-bottom:5px;font-size:14px;">Quantity: {{ $row->qty }}</p>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<img src="{{ asset('images/emails/hr.png') }}" style="display:block" border="0" />
	</td>
</tr>
@endforeach

<tr>
	<td>
        <img src="{{ asset('images/emails/stand.jpg')}}" alt="LSi at SMMEX" />
	</td>
</tr>

<tr>
	<td>
        <p style="font-size:14px; margin-top:20px; margin-bottom:20px;">Thank you for visiting us. Visit <a href="http://lsi.co.uk" style="color:#EC008C;">LSi</a> for all your promotional needs.</p>
	</td>
</tr>

<tr>
	<td>
        <p style="font-size:11px; margin-top:30px; margin-bottom:20px;">
            &copy; <a href="http://lsi.co.uk">LSi</a> 2018 @if(date('Y') !== '2018') &ndash; {{ date('Y') }} @endif
            <br>Braemar House, Snelsins Road, Cleckheaton, West Yorkshire, BD19 3UE
            <br>Tel: (01274) 854996
            <br>Web: <a href="http://lsi.co.uk">LSi.co.uk</a>
        </p>
	</td>
</tr>

@endsection