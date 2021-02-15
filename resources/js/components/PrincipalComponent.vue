<template>
    <div class="container container-task">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" v-if="update == 0">Crear paciente</h5>
                        <h5 class="modal-title" id="exampleModalLabel" v-if="update != 0">Actualizar paciente</h5>
                        <br>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nombre</label>
                                    <input v-model="name" type="text" class="form-control">

                                    <label>Email</label>
                                    <input v-model="email" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Telefono</label>
                                    <input v-model="phone" type="number" class="form-control">

                                    <label>Ocupacion</label>
                                    <select v-model="ocupation" class="form-control">
                                        <option value="1">Maestro</option>
                                        <option value="2">Tecnico</option>
                                        <option value="3">Ama de casa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nombre facturacion</label>
                                    <input v-model="name_tax" type="text" class="form-control">

                                    <label>NIT</label>
                                    <input v-model="tax_id" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Peso</label>
                                    <input v-model="weight" type="number" class="form-control">

                                    <label>Altura</label>
                                    <input v-model="height" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Estado civil</label>
                                    <select v-model="marital_status" class="form-control">
                                        <option value="1">Soltero</option>
                                        <option value="2">Casado</option>
                                        <option value="3">Divorciado</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Aseguradora</label>
                                    <select v-model="insurance" class="form-control">
                                        <option value="1">Seguros Agromercantil</option>
                                        <option value="2">Seguros Azul</option>
                                        <option value="3">Seguros El Roble</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Fecha nacimiento</label>
                                    <input v-model="birthdate" type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="update == 0" @click="saveTasks()" class="btn btn-success">Añadir</button>
                        <button v-if="update != 0" @click="updateTasks()" class="btn btn-warning">Actualizar</button>
                        <button v-if="update != 0" @click="clearFields()" class="btn">Atrás</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
          + Crear paciente
        </button>

        <div class="row" style="margin-top: 10px">
            
            <div class="col-md-12">
                <!--<table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Ocupacion</th>
                            <th scope="col">Nombre facturacion</th>
                            <th scope="col">NIT</th>
                            <th scope="col">Peso</th>
                            <th scope="col">Altura</th>
                            <th scope="col">Estado civil</th>
                            <th scope="col">Aseguradora</th>
                            <th scope="col">Fecha nacimiento</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in arrayTasks" :key="task.id"> 
                            <td v-text="task.name"></td>
                            <td v-text="task.email"></td>
                            <td v-text="task.phone"></td>
                            <td v-if ="task.ocupation == 1">Maestro</td>
                            <td v-if ="task.ocupation == 2">Tecnico</td>
                            <td v-if ="task.ocupation == 3">Ama de casa</td>
                            <td v-text="task.name_tax"></td>
                            <td v-text="task.tax_id"></td>
                            <td v-text="task.weight"></td>
                            <td v-text="task.height"></td>
                            <td v-if ="task.marital_status == 1">Soltero</td>
                            <td v-if ="task.marital_status == 2">Casado</td>
                            <td v-if ="task.marital_status == 3">Divorciado</td>
                            <td v-if ="task.insurance == 1">Seguros Agromercantil</td>
                            <td v-if ="task.insurance == 2">Seguros Azul</td>
                            <td v-if ="task.insurance == 3">Seguros El Roble</td>
                            <td v-text="task.birthdate"></td>
                            <td>
                                
                                <button class="btn btn-info" @click="loadFieldsUpdate(task)">Modificar</button><br><br>
                                
                                <button class="btn btn-danger" @click="deleteTask(task)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>-->
                <data-table
                    :columns="columns"
                    url="/api/patients" ref="myTable">
                </data-table>
            </div>
        </div>
    </div>
</template>
<script>
    import EditButton from './EditButton.vue';
    import DeleteButton from './DeleteButton.vue';
    import $ from 'jquery';
    export default {
        /*
        data(){
            return{
                id:"",
                name : "",
                email : "",
                phone : "",
                ocupation : "",
                name_tax : "",
                tax_id : "",
                weight : "",
                height : "",
                marital_status : "",
                insurance : "",
                birthdate : "",
                update:0, 
                arrayTasks:[],
            }
        },
        */
        data() {
            return {
                id:"",
                name : "",
                email : "",
                phone : "",
                ocupation : "",
                name_tax : "",
                tax_id : "",
                weight : "",
                height : "",
                marital_status : "",
                insurance : "",
                birthdate : "",
                update:0, 
                arrayTasks:[],
                columns: [
                    {
                        label: 'ID',
                        name: 'id',
                        orderable: true,
                    },
                    {
                        label: 'Nombre',
                        name: 'name',
                        orderable: true,
                    },
                    {
                        label: 'Correo Electronico',
                        name: 'email',
                        orderable: true,
                    },
                    {
                        label: 'Telefono',
                        name: 'phone',
                        orderable: true,
                    },
                    {
                        label: 'Ocupacion',
                        name: 'ocupation',
                        orderable: true,
                    },
                    {
                        label: 'Nombre facturacion',
                        name: 'name_tax',
                        orderable: true,
                    },
                    {
                        label: 'Nit',
                        name: 'tax_id',
                        orderable: true,
                    },
                    {
                        label: 'Peso',
                        name: 'weight',
                        orderable: false,
                    },
                    {
                        label: 'Altura',
                        name: 'height',
                        orderable: false,
                    },
                    {
                        label: 'Estado civil',
                        name: 'marital_status',
                        orderable: false,
                    },
                    {
                        label: 'Aseguradora',
                        name: 'insurance',
                        orderable: false,
                    },
                    {
                        label: 'Fecha nacimiento',
                        name: 'birthdate',
                        orderable: false,
                    },
                    {
                        label: 'Editar',
                        name: 'Editar',
                        orderable: false,
                        classes: { 
                            'btn': true,
                            'btn-primary': true,
                            'btn-sm': true,
                        },
                        event: "click",
                        handler: this.loadFieldsUpdate,
                        component: EditButton, 
                    },
                    {
                        label: 'Eliminar',
                        name: 'Eliminar',
                        orderable: false,
                        classes: { 
                            'btn': true,
                            'btn-danger': true,
                            'btn-sm': true,
                        },
                        event: "click",
                        handler: this.deleteTask,
                        component: DeleteButton, 
                    },
                ]
            }
        },
        components: {
            EditButton,
            DeleteButton
        },
        methods:{
            getTasks(){
                this.$refs.myTable.getData();
            },
            saveTasks(){
                let me =this;
                let url = '/api/patients' 
                axios.post(url,{ 
                    'name': this.name,
                    'email': this.email,
                    'phone': this.phone,
                    'ocupation': this.ocupation,
                    'name_tax': this.name_tax,
                    'tax_id': this.tax_id,
                    'weight': this.weight,
                    'height': this.height,
                    'marital_status': this.marital_status,
                    'insurance': this.insurance,
                    'birthdate': this.birthdate,
                }).then(function (response) {
                    console.log(response);
                    if (response.data.result == false) {
                        alert(response.data.message);
                    }else{
                        me.getTasks();
                        me.clearFields();
                        $('#exampleModal').modal('hide');
                    }
                })
                .catch(function (error) {
                    alert(error);
                    console.log(error);
                });   

            },
            updateTasks(){
                let me = this;
                axios.put('/api/patients/'+me.id,{
                    'name': me.name,
                    'email': me.email,
                    'phone': me.phone,
                    'ocupation': me.ocupation,
                    'name_tax': me.name_tax,
                    'tax_id': me.tax_id,
                    'weight': me.weight,
                    'height': me.height,
                    'marital_status': me.marital_status,
                    'insurance': me.insurance,
                    'birthdate': me.birthdate,
                }).then(function (response) {
                    $('#exampleModal').modal('hide');
                   me.getTasks();
                   me.clearFields();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ 
                $('#exampleModal').modal('show');
                this.update = data.id
                let me =this;
                let url = '/api/patients/'+this.update;
                axios.get(url).then(function (response) {
                    me.id= response.data.records.id;
                    me.name= response.data.records.name;
                    me.email= response.data.records.email;
                    me.phone= response.data.records.phone;
                    me.ocupation= response.data.records.ocupation;
                    me.name_tax= response.data.records.name_tax;
                    me.tax_id= response.data.records.tax_id;
                    me.weight= response.data.records.weight;
                    me.height= response.data.records.height;
                    me.marital_status= response.data.records.marital_status;
                    me.insurance= response.data.records.insurance;
                    me.birthdate= response.data.records.birthdate;

                })
                .catch(function (error) {
                    console.log(error);
                }); 
            },
            deleteTask(data){
                let me =this;
                let task_id = data.id
                if (confirm('¿Seguro que deseas eliminar esta paciente?')) {
                    axios.delete('/api/patients/'+task_id
                    ).then(function (response) {
                        me.getTasks();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){
                this.id="",
                this.name = "";
                this.email = "";
                this.phone = "";
                this.ocupation = "";
                this.name_tax = "";
                this.tax_id = "";
                this.weight = "";
                this.height = "";
                this.marital_status = "";
                this.insurance = "";
                this.birthdate = "";
                this.update = 0;
                $('#exampleModal').modal('hide');
            }
        },
        mounted() {
           this.getTasks();
        }
    }
</script>