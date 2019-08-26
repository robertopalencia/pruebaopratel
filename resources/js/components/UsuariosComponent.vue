<template>
    <div class="container">
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Phone</th>
                    <th scope="col">Site</th>
                    <th>
                        <button type="button" class="btn btn-success" @click="openModal('addUser')">
                        Agregar
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="usuarios in arrayUsuarios" :key="usuarios.id">
                    <td v-text="usuarios.phone"></td>
                    <td v-text="usuarios.site"></td>
                    <td>
                        <button type="button" class="btn btn-warning" @click="openModal('addPayment', usuarios)">
                        Pago
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" v-bind:class="{ 'mostrar' : modal }" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="tituloModal"></h5>
                        <button type="button" class="close" @click="cerrarModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" v-model="phone" placeholder="1112345678">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="site" class="col-sm-2 col-form-label">Sitio</label>
                            <div class="col-sm-10">
                                <input type="text" name="site" v-model="site" placeholder="www.google.com">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" v-model="password" placeholder="*************">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="addUser()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" v-bind:class="{ 'mostrar' : modalpago }" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="tituloModal"></h5>
                        <button type="button" class="close" @click="cerrarModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>Telefono: <p v-text="phone"></p></h4>
                        <div class="form-group row">
                            <label for="pago" class="col-sm-2 col-form-label">Monto</label>
                            <div class="col-sm-10">
                                <input type="number" name="amount" v-model="amount" placeholder="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cancelar</button>
                        <button type="button" class="btn btn-primary"  @click="addPayment()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
    data(){
    return {
        amount: '',
        phone : '',
        site: '',
        id: '',
        password:'',
        arrayUsuarios : [],
        modal : 0,
        tituloModal: '',
        modalpago: 0
    }
    },
        methods: {
            getUsers(){
                let users=this;
                axios.get('/api/usuarios')
                    .then(function (response) {
                       users.arrayUsuarios = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            addUser(){
                let me = this;
                axios.post('/api/agregar_usuario', {
                    phone: this.phone,
                    password: this.password,
                    site: this.site
                })
                    .then(function (response) {
                        me.cerrarModal();
                        me.getUsers();
                        alert('Usuario agregado con exito');
                        console.log(response);
                    })
                    .catch(function (error) {
                        if(error.response.status === 400){
                            alert(error.response.data);
                        }
                        console.log(error);
                    });
            },
            addPayment(){
                let me = this;
                axios.post('/api/agregar_pago', {
                    phone: this.phone,
                    amount: this.amount,
                })
                    .then(function (response) {
                        me.cerrarModal();
                        me.getUsers();
                        alert('Pago Realizado con exito');
                        console.log(response);
                    })
                    .catch(function (error) {
                        if(error.response.status === 400){
                            alert(error.response.data);
                        }
                        console.log(error);

                    });
            },
            openModal(accion, data = []){
                switch(accion){
                    case 'addUser':
                    {
                        this.modal = 1;
                        this.phone = '';
                        this.site = '';
                        this.password = '';
                        this.id='';
                        this.tituloModal = 'Agregar Usuario';
                        break;
                    }
                    case 'addPayment':
                    {
                        this.id=data.id;
                        this.phone=data.phone;
                        this.tituloModal = 'Agregar Pago';
                        this.modalpago=1;
                        break;
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.modalpago=0;
                this.phone = '';
                this.site = '';
                this.password = '';
                this.id='';
                this.amount='';
                this.tituloModal = '';
            }
        },
        mounted() {
            this.getUsers();
        }
    }
</script>
<style>
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a;
    }
    .modal-content{
        width:100% !important;
        position: absolute !important;
    }
</style>