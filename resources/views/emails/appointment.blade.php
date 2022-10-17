<div>
    Hello, {{$appointment->first_name}} {{$appointment->last_name}},<br/>
    don't forget about your notary meeting(subject - {{$appointment->type->name}}) at {{$appointment->visit_date}}
</div>

