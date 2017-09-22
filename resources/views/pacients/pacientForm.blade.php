<html>
    <body>
    <h1>Add a Pacient</h1>
        {{ Form::open(array("action" => "PacientsController@addPacient")) }}
            {{ Form::label('name', 'Name', array('class'=>'control-label')) }}
            {{ Form::text('name') }}
    <br />
            {{ Form::label('address', 'Address', array('class'=>'control-label')) }}
            {{ Form::text('address') }}
    <br />
            {{ Form::label('phone', 'Phone Number', array('class'=>'control-label')) }}
            {{ Form::text('phone') }}
    <br />
            {{ Form::label('genre', 'Genre', array('class'=>'control-label')) }}
            {{ Form::text('genre') }}
    <br />
            {{ Form::submit('save', array('class' => 'btn btn-default')) }}
        {{ Form::close() }}
    </body>
</html>