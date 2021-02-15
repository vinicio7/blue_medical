<template>
    <div class="container container-task">
        <div class="col-md-6">
                <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                    <label>Nombre</label>
                    <input v-model="name" type="text" class="form-control">

                    <label>Email</label>
                    <input v-model="email" type="text" class="form-control">

                    <label>Telefono</label>
                    <input v-model="phone" type="number" class="form-control">

                    <label>Ocupacion</label>
                    <input v-model="ocupation" type="text" class="form-control">

                    <label>Nombre facturacion</label>
                    <input v-model="name_tax" type="text" class="form-control">

                    <label>NIT</label>
                    <input v-model="tax_id" type="number" class="form-control">

                    <label>Peso</label>
                    <input v-model="weight" type="number" class="form-control">

                    <label>Altura</label>
                    <input v-model="height" type="number" class="form-control">

                    <label>Estado civil</label>
                    <input v-model="marital_status" type="text" class="form-control">

                    <label>Aseguradora</label>
                    <input v-model="insurance" type="text" class="form-control">

                    <label>Fecha nacimiento</label>
                    <input v-model="birthdate" type="date" class="form-control">
                </div>
                <div class="container-buttons">
                    <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                    <button v-if="update == 0" @click="saveTasks()" class="btn btn-success">Añadir</button>
                    <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="updateTasks()" class="btn btn-warning">Actualizar</button>
                    <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                    <button v-if="update != 0" @click="clearFields()" class="btn">Atrás</button>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Lista de pacientes</h2>
                <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
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
                            <tr v-for="task in arrayTasks" :key="task.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                <td v-text="task.name"></td>
                                <td v-text="task.email"></td>
                                <td v-text="task.phone"></td>
                                <td v-text="task.ocupation"></td>
                                <td v-text="task.name_tax"></td>
                                <td v-text="task.tax_id"></td>
                                <td v-text="task.weight"></td>
                                <td v-text="task.height"></td>
                                <td v-text="task.marital_status"></td>
                                <td v-text="task.insurance"></td>
                                <td v-text="task.birthdate"></td>
                                <td>
                                    <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                    <button class="btn" @click="loadFieldsUpdate(task)">Modificar</button>
                                    <!--Botón que borra la tarea que seleccionemos-->
                                    <button class="btn" @click="deleteTask(task)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
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
                update:0, /*Esta variable contrarolará cuando es una nueva tarea o una modificación, si es 0 significará que no hemos seleccionado
                          ninguna tarea, pero si es diferente de 0 entonces tendrá el id de la tarea y no mostrará el boton guardar sino el modificar*/
                arrayTasks:[], //Este array contendrá las tareas de nuestra bd
            }
        },
        methods:{
            getTasks(){
                console.log("entro");
                let me =this;
                let url = '/api/patients' //Ruta que hemos creado para que nos devuelva todas las tareas
                axios.get(url).then(function (response) {
                    console.log(response.data.records);
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.arrayTasks = response.data.records;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            saveTasks(){
                let me =this;
                let url = '/api/patients' //Ruta que hemos creado para enviar una tarea y guardarla
                axios.post(url,{ //estas variables son las que enviaremos para que crear la tarea
                    'name':this.name,
                    'description':this.description,
                    'content':this.content,
                }).then(function (response) {
                    me.getTasks();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                    me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });   

            },
            updateTasks(){/*Esta funcion, es igual que la anterior, solo que tambien envia la variable update que contiene el id de la
                tarea que queremos modificar*/
                let me = this;
                axios.put('/api/patients',{
                    'id':this.update,
                    'name':this.name,
                    'description':this.description,
                    'content':this.content,
                }).then(function (response) {
                   me.getTasks();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                   me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ //Esta función rellena los campos y la variable update, con la tarea que queremos modificar
                this.update = data.id
                let me =this;
                let url = '/api/patients?id='+this.update;
                axios.get(url).then(function (response) {
                    me.name= response.data.name;
                    me.description= response.data.description;
                    me.content= response.data.content;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deleteTask(data){//Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegido
                let me =this;
                let task_id = data.id
                if (confirm('¿Seguro que deseas borrar esta tarea?')) {
                    axios.delete('/api/patients/'+task_id
                    ).then(function (response) {
                        me.getTasks();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/
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
            }
        },
        mounted() {
           this.getTasks();
        }
    }
</script>