<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="appointment-sender col-12 col-md-6 col-lg-5 col-xl-4 mt-3">
                <h3 class="appointment-sender__title">
                    Send your appointment
                </h3>
                <form @submit.prevent="tryToSendAppointment">
                    <div class="form-group">
                        <label for="first_name">First name</label>
                        <input type="text" class="form-control" v-model="formData.first_name"
                               id="first_name" name="first_name" placeholder="e.g. Walter">
                    </div>
                    <div class="form-group mt-2">
                        <label for="last_name">Last name</label>
                        <input type="text" class="form-control"  v-model="formData.last_name"
                               id="last_name" name="last_name" placeholder="e.g. White">
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" v-model="formData.email"
                               id="email" name="email" placeholder="example@exa.mple">
                    </div>
                    <div class="form-group mt-2">
                        <label for="visit_date">Visit date</label>
                        <input type="date" class="form-control" id="visit_date" v-model="formData.visit_date"
                            :min="new Date().toJSON().split('T')[0]"
                        >
                    </div>
                    <div class="form-group mt-2">
                        <label for="type_id">Subject type</label>
                        <select class="form-control" id="type_id" v-model="formData.type_id">
                            <option disabled selected>Choose one</option>
                            <option v-for="(appointmentType, appointmentTypeIndex) in appointmentTypes" :key="appointmentTypeIndex"
                                    :value="appointmentType.id"
                            >
                                {{appointmentType.name}}
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    <ValidationErrorList :validationErrors="validationErrors"/>
                    <div v-if="errorMessage" class="text-danger">
                        {{errorMessage}}
                    </div>
                </form>
            </div>
            <div class="appointment-list mt-3">
                <div v-if="appointments">
                    <h3 class="appointment-list__title">
                        You have an appointments
                    </h3>

                    <div v-for="(appointment, appointmentsIndex) in appointments" :key="appointmentsIndex"
                         class="mt-3 p-2 border border-dark"
                    >
                        Signed as:  <i>{{appointment.first_name}} {{appointment.first_name}}</i><br/>
                        Visit date: <i>{{appointment.visit_date}}</i><br/>
                        Subject type: <i>{{appointment.type.name}}</i>
                    </div>

                </div>
                <div v-else>
                    <h3 class="appointment-list__title">
                        You don't have an appointments
                    </h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidateHelper from "../Helpers/ValidateHelper";
import ValidationErrorList from "./ValidationErrorList";

export default {
    components: {ValidationErrorList},
    data: () => {
        let initialFormData = {
            first_name: '',
            last_name: '',
            user_id: '',
            email: '',
            visit_date: '',
            type_id: '',
        };

        return {
            initialFormData,
            formData: {...initialFormData},
            attributeNames: {
                first_name: 'First Name',
                last_name: 'Last Name',
                email: 'Email',
                visit_date: 'Visit date',
                type_id: 'Subject type',
            },
            appointments: window.appointments.data ?? [],
            appointmentTypes: window.appointmentTypes,
            validationErrors: {},
            errorMessage: ''
        };
    },
    methods: {
        async tryToSendAppointment() {
            this.validationErrors = ValidateHelper.validateForm(this.formData, window.validatoinRules, this.attributeNames);
            if (!Object.keys(this.validationErrors).length) {
                let response = await axios.post('/api/appointments', {...this.formData, user_id: document.cookie.user_id})
                    .then(function (response) {
                        return response;
                    })
                    .catch(function (error) {
                        return error;
                    });

                this.formData = this.initialFormData;

                if (response.hasOwnProperty('status') && response.status === 201) {
                    this.appointments.unshift(response.data);
                } else {
                    this.errorMessage = 'There were some problem with request';
                    setTimeout(() => {this.errorMessage = ''}, 5000);
                }
            }
        }
    }
}
</script>

<style>
.appointment-list__title {
    margin: auto;
    text-align: center;
}
</style>
