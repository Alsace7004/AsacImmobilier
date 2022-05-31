<template>
    <div class="container">
        <page-title title="Les Clients"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Clients</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                      <th>Prenom</th>
                      <th>Adresse</th>
                      <th>Telephone</th>
                      <th>Profession</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!clients.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de clients disponible...</tr>
                    <tr v-for="client in clients" :key="client.id">
                      <td>{{client.id}}</td>
                      <td>{{client.nom}}</td>
                      <td>{{client.prenom1}}</td>
                      <td>{{(client.adresse)}}</td>
                      <td>{{client.telephone}}</td>
                       <td>{{client.profession}}</td>
                      <td><span class="tag tag-success">{{convert(client.created_at)}}</span></td>
                      <td>
                          <button @click="editClient(client.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteClient(client.id)" class="btn btn-danger btn-sm">Delete</button>
                      </td>
                    </tr>
                    
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
         <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Client":"Add New Client"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateClient() : createClient()">
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" v-model="client.CIN"  id="CIN" placeholder="CIN du Client..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="client.nom" id="nom" placeholder="Nom du Client..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="client.prenom1" id="prenom1" placeholder="Prenom1 du Client..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="client.prenom2" id="prenom2" placeholder="Prenom2 du Client..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="client.adresse" id="adresse" placeholder="Adresse du Client..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="client.telephone" id="telephone" placeholder="Telephone du Client..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="client.profession" id="profession" placeholder="Profession du Client..." class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{is_Editing ?"Update":"Create"}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                clients:[],
                client:{
                    CIN:'',
                    nom:'',
                    prenom1:'',
                    prenom2:'',
                    adresse:'',
                    telephone:'',
                    profession:'',
                },
                edit_id:'',
                is_Editing:false,
            }
        },
        methods:{
            convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            newModal(){
                this.client={
                        CIN:'',
                        nom:'',
                        prenom1:'',
                        prenom2:'',
                        adresse:'',
                        telephone:'',
                        profession:'',
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadClients(){
                axios.get('api/clients').then((clients)=>{
                    this.clients = clients.data;
                })
            },
            createClient(){
                let cin = document.querySelector("#CIN").value;
                let nm = document.querySelector("#nom").value;
                let pr = document.querySelector("#prenom1").value;
                let ad = document.querySelector("#adresse").value;
                let tel = document.querySelector("#telephone").value;
                let prf= document.querySelector("#profession").value;
                if(cin ==""||nm =="" ||pr ==""|| ad=="" || tel==""||prf==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/clients`,this.client).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Client Ajouter avec success.','success') ;
                    this.loadClients();
                    this.client={
                        CIN:'',
                        nom:'',
                        prenom1:'',
                        prenom2:'',
                        adresse:'',
                        telephone:'',
                        profession:'',
                    }
                }).catch((err)=>{
                    Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                })
            },
            deleteClient(id){
                    Swal.fire({
                    title: 'Etes vous sûr???',
                    text: "Pas de récuperation possible!!!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimer le'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`api/clients/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Le Client a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadClients();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Client est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteClient
            editClient(id){
                axios.get(`api/clients/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.client.CIN = res.data.CIN;
                    this.client.nom = res.data.nom;
                    this.client.prenom1 = res.data.prenom1;
                    this.client.prenom2 = res.data.prenom2;
                    this.client.adresse = res.data.adresse;
                    this.client.telephone = res.data.telephone;
                    this.client.profession = res.data.profession;
                    this.is_Editing = true;
                })
            },
            updateClient(){
                    axios.put(`api/clients/${this.edit_id}`,this.client).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Client(e) mise à jour avec success.','success')    
                        this.loadClients();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadClients();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
