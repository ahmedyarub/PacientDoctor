<html>
    <body>
    <h1>Add a Pacient</h1>
        {{ Form::open(array("action" => "PacientsController@addPacient")) }}
            {{ Form::label('name', 'Name', array('class'=>'control-label')) }}
            {{ Form::text('name') }}
            {{ Form::label('address', 'Address', array('class'=>'control-label')) }}
            {{ Form::text('address') }}
            {{ Form::label('phone', 'Phone Number', array('class'=>'control-label')) }}
            {{ Form::text('phone') }}
            {{ Form::submit('save', array('class' => 'btn btn-default')) }}
        {{ Form::close() }}
    </body>
</html>