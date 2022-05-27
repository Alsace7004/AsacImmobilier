<template>
    <div class="container">
        <page-title title="Les visites"/>
         <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Visites</h3>

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
                      <th>Client</th>
                      <th>Appartement</th>
                      <th>Remarque</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="visite in visites" :key="visite.id">
                      <td>{{visite.id}}</td>
                      <td>{{visite.client_id}}</td>
                      <td>{{visite.appartement_id}}</td>
                      <td>{{getPostBody(visite.remarque_client)}}</td>
                      <td><span class="tag tag-success">{{convert(visite.created_at)}}</span></td>
                      <td>
                          <button @click="editVisite(visite.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteVisite(visite.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Visite":"Add New Visite"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateVisite() : createVisite()">
                        <div class="modal-body">     
                                    <div class="form-group">
                                        <select  v-model="visite.client_id" id="client_id" class="form-control">
                                            <option value="" hidden selected>Selectionner le client</option>
                                            <option v-for="client in clients" :key="client.id" :value="client.id" >{{client.nom}} {{client.prenom1}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select  v-model="visite.appartement_id" id="appartement_id" class="form-control">
                                            <option value="" hidden selected>Selectionner un Appart</option>
                                            <option v-for="appartement in appartements" :key="appartement.id" :value="appartement.id">{{appartement.appartement_immeuble}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="" v-model="visite.remarque_client" id="remarque_client" cols="5" rows="2" class="form-control" placeholder="Remarque du Client..."></textarea>
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
                appartements:[],
                visites:[],
                visite:{
                    client_id:'',
                    appartement_id:'',
                    remarque_client:'',
                },
                edit_id:'',
                is_Editing:false,
            }
        },
        methods:{
            getPostBody (post) {
                //let body = this.stripTags(post.body);
                
                return post.length > 5 ? post.substring(0, 300) + '...' : post;           
            },
            /*stripTags (text) {
                return text.replace(/(<([^>]+)>)/ig, '');
            },*/
            convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            newModal(){
                this.visite={
                        client_id:'',
                        appartement_id:'',
                        remarque_client:'',
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadClients(){
                axios.get('api/clients').then((clients)=>{
                    this.clients = clients.data;
                })
            },
            loadAppartements(){
                axios.get('api/appartements').then((appartements)=>{
                    this.appartements = appartements.data;
                })
            },
            loadVisites(){
                axios.get('api/visites').then((visites)=>{
                    this.visites = visites.data;
                })
            },

            createVisite(){
                let cid = document.querySelector("#client_id").value;
                let ap = document.querySelector("#appartement_id").value;
                let ri = document.querySelector("#remarque_client").value;
                
                if(cid==""||ap =="" ||ri ==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/visites`,this.visite).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Visite Ajouter avec success.','success') ;
                    this.loadVisites();
                    this.visite={
                        client_id:'',
                        appartement_id:'',
                        remarque_client:''
                    }
                }).catch((err)=>{
                    Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                })
            },
            deleteVisite(id){
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
                            axios.delete(`api/visites/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'La Visite a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadVisites();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Visite est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteVisite
            editVisite(id){
                axios.get(`api/visites/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.visite.client_id = res.data.client_id;
                    this.visite.appartement_id = res.data.appartement_id;
                    this.visite.remarque_client = res.data.remarque_client;
                    this.is_Editing = true;
                })
            },
            updateVisite(){
                    axios.put(`api/visites/${this.edit_id}`,this.visite).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Visite mise à jour avec success.','success')    
                        this.loadVisites();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadVisites();
            this.loadClients();
            this.loadAppartements();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
