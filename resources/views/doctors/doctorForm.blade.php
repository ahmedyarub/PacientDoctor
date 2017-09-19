<html>
    <body>
    <h1>Add a Doctor</h1>
        {{ Form::open(array("action" => "DoctorsController@addDoctor")) }}
            {{ Form::label('name', 'Name', array('class'=>'control-label')) }}
            {{ Form::text('name') }}
            {{ Form::label('crm', 'CRM', array('class'=>'control-label')) }}
            {{ Form::text('crm') }}
            {{ Form::label('phone', 'Phone Number', array('class'=>'control-label')) }}
            {{ Form::text('phone') }}
            {{ Form::submit('Save', array('class' => 'btn btn-default')) }}
        {{ Form::close() }}
    </body>
</html>