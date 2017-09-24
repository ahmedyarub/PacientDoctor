<html>
    <body>
    <h1>Add a Doctor</h1>
        {{ Form::open(array("action" => "DoctorsController@addDoctor")) }}
            {{ Form::label('name', 'Name', array('class'=>'control-label')) }}
            {{ Form::text('name') }}
    <br />
            {{ Form::label('crm', 'CRM', array('class'=>'control-label')) }}
            {{ Form::text('crm') }}
    <br />
            {{ Form::label('email', 'Email', array('class'=>'control-label')) }}
            {{ Form::text('email') }}
    <br />
            {{ Form::label('password', 'Password', array('class'=>'control-label')) }}
            {{ Form::password('password') }}
    <br />
            {{ Form::label('address', 'Address', array('class'=>'control-label')) }}
            {{ Form::text('address') }}
    <br />
            {{ Form::label('phone', 'Phone Number', array('class'=>'control-label')) }}
            {{ Form::text('phone') }}
    <br />
            {{ Form::submit('Save', array('class' => 'btn btn-default')) }}
        {{ Form::close() }}
    </body>
</html>