<template>
    <div class="container">
        <page-title title="Les proces Verbales"/>
         <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Proces Verbals</h3>

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
                      <th>Directeur Commercial</th>
                      <th>Contrat Vente</th>
                      <th>Signature Acquereur</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!procesverbals.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de Proces Verbals disponible...</tr>
                    <tr v-for="procesverbal in procesverbals" :key="procesverbal.id">
                      <td>{{procesverbal.id}}</td>
                      <td>{{procesverbal.name}}</td>
                      <td>{{procesverbal.client_appartement_immeuble}}</td>
                      <td>{{(procesverbal.signature_acquereur)}}</td>
                      <td><span class="tag tag-success">{{convert(procesverbal.created_at)}}</span></td>
                      <td>
                          <button @click="editProcesVerbal(procesverbal.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteProcesVerbal(procesverbal.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Proces Verbal":"Add New Proces Verbal"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateProcesVerbal() : createProcesVerbal()">
                        <div class="modal-body">
                            

                                    <div class="form-group">
                                        <select  v-model="procesverbal.contrat_vente_definitif_id" id="contrat_vente_definitif_id" class="form-control">
                                            <option value="" hidden selected>Contrat Vente</option>
                                            <option v-for="contratventedefinitif in contratventedefinitifs" :key="contratventedefinitif.id" :value="contratventedefinitif.id" >{{contratventedefinitif.client_appartement_immeuble}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select  v-model="procesverbal.user_id" id="user_id" class="form-control">
                                            <option value="" hidden selected>Utilisateurs</option>
                                            <option v-for="user in users" :key="user.id" :value="user.id" >{{user.email}}</option>
                                        </select>
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
                users:[],
                contratventedefinitifs:[],
                procesverbals:[],
                procesverbal:{
                    user_id:'0',
                    contrat_vente_definitif_id:'',
                    signature_acquereur:'0',
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
                this.procesverbal={
                    user_id:'0',
                    contrat_vente_definitif_id:'',
                    signature_acquereur:'0',
                }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadProcesVerbals(){
                axios.get('api/procesVerbals').then((procesverbals)=>{
                    this.procesverbals = procesverbals.data;
                })
            },
            loadContratVenteDefinitifs(){
                axios.get('api/contratVenteDefinitifs').then((contratventedefinitifs)=>{
                    this.contratventedefinitifs = contratventedefinitifs.data;
                })
            },
            loadUsers(){
                axios.get('api/users').then((users)=>{
                    this.users = users.data;
                })
            },
            createProcesVerbal(){
                    axios.post('api/procesVerbals',this.procesverbal).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Proces Verbal Ajouter avec success.','success') ;
                    this.loadProcesVerbals();
                    this.procesverbal={
                        user_id:'0',
                        contrat_vente_definitif_id:'',
                        signature_acquereur:'0',
                    }
                    }).catch((err)=>{
                        //Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            if(err.response.data.errors.contrat_vente_definitif_id){
                                //Swal.fire('Error !!!',`Ce Proces Verbal existe déjà ${err.response.data.errors.contrat_vente_definitif_id}`,'error')
                                Swal.fire('Error !!!',`Ce Proces Verbal existe déjà`,'error')
                            }else{
                                Swal.fire('Error !!!',`Une erreur est survenue`,'error')
                            }
                    });
            },
            deleteProcesVerbal(id){
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
                            axios.delete(`api/procesVerbals/${id}`).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'Le Proces Verbal a été supprimé.',
                                    'success'
                                    )
                                this.loadProcesVerbals();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Proces Verbal est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteProcesVerbal
            editProcesVerbal(id){
                axios.get(`api/procesVerbals/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.procesverbal.contrat_vente_definitif_id = res.data.contrat_vente_definitif_id;
                    this.is_Editing = true;
                })
            },
            updateProcesVerbal(){
                    axios.put(`api/procesVerbals/${this.edit_id}`,this.procesverbal).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Proces Verbal mise à jour avec success.','success')    
                        this.loadProcesVerbals();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadUsers();
            this.loadProcesVerbals();
            this.loadContratVenteDefinitifs();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
