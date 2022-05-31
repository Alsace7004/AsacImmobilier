<template>
    <div class="container">
        <page-title title="Les Desistements"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Desistements</h3>

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
                      <th>Numero</th>
                      <th>Promesse Vente</th>
                      <th>Causes Anulation</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!desistements.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de desistements disponible...</tr>
                    <tr v-for="desistement in desistements" :key="desistement.id">
                      <td>{{desistement.id}}</td>
                      <td>{{desistement.numero}}</td>
                      <td>{{desistement.client_appartement_immeuble}}</td>
                      <td>{{truncate(desistement.causes_annulation,30)}}</td>
                      <td><span class="tag tag-success">{{convert(desistement.created_at)}}</span></td>
                      <td>
                          <button @click="editDesistement(desistement.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteDesistement(desistement.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Desistement":"Add New Desistement"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateDesistement() : createDesistement()">
                        <div class="modal-body">
                                <div class="form-group">
                                        <select  v-model="desistement.promesse_vente_id" id="promesse_vente_id" class="form-control">
                                            <option value="" hidden selected>Selectionner une promesse vente</option>
                                            <option v-for="promessevente in promesseventes" :key="promessevente.id" :value="promessevente.id" >{{promessevente.client_appartement_immeuble}}</option>
                                        </select>
                                </div> 
                                <div class="form-group">
                                    <textarea name="" v-model="desistement.causes_annulation" class="form-control" placeholder="causes de l'annulation de la promesse de vente..." id="causes_annulation" cols="5" rows="2"></textarea>
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
                promesseventes:[],
                desistements:[],
                desistement:{
                    promesse_vente_id:'',
                    numero:'',
                    causes_annulation:''
                },
                edit_id:'',
                is_Editing:false,
            }
        },
        methods:{
            truncate(str, n){
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
            convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            newModal(){
                this.desistement={
                        promesse_vente_id:'',
                        numero:'0',
                        causes_annulation:''
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadDesistements(){
                axios.get('api/desistements').then((desistements)=>{
                    this.desistements = desistements.data;
                })
            },
            loadPromesseVentesCIA(){
                axios.get('api/clientIA').then((promesseventes)=>{
                    this.promesseventes = promesseventes.data;
                })
            },
            createDesistement(){
                let pvid = document.querySelector("#promesse_vente_id").value;
                let ca = document.querySelector("#causes_annulation").value;
                if(pvid ==""||ca ==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/desistements`,this.desistement).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Desistement Ajouter avec success.','success') ;
                    this.loadDesistements();
                    this.desistement={
                        promesse_vente_id:'',
                        numero:'',
                        causes_annulation:''
                    }
                }).catch((err)=>{
                    //Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                           if(err.response.data.errors.promesse_vente_id){
                                //Swal.fire('Error !!!',`Ce desistement existe déjà ${err.response.data.errors.promesse_vente_id}`,'error')
                                Swal.fire('Error !!!',`Ce desistement existe déjà`,'error')
                            }else{
                                    Swal.fire('Error !!!',`Une erreur est survenue`,'error')
                            }
                })
            },
            deleteDesistement(id){
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
                            axios.delete(`api/desistements/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Desistement a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadDesistements();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Desistement est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteDesistement
            editDesistement(id){
                axios.get(`api/desistements/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.desistement.promesse_vente_id = res.data.promesse_vente_id;
                    this.desistement.causes_annulation = res.data.causes_annulation;
                    this.desistement.numero = res.data.numero;
                    this.is_Editing = true;
                })
            },
            updateDesistement(){
                    axios.put(`api/desistements/${this.edit_id}`,this.desistement).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Desistement mise à jour avec success.','success')    
                        this.loadDesistements();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadDesistements();
            this.loadPromesseVentesCIA();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
