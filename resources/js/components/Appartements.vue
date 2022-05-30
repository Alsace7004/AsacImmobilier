<template>
    <div class="container">
        <page-title title="Les Appartements"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Appartements</h3>

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
                      <!--<th>N* Etage</th>
                      <th>N* Appart(Etage)</th>-->
                      <th>Numero</th>
                      <th>Superficie</th>
                      <th>Nbr Chambre</th>
                      <th>Prix</th>
                      <th>Type</th>
                      <th>Appart/Immeuble</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!appartements.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas d'Appartements disponible...</tr>
                    <tr v-for="appartement in appartements" :key="appartement.id">
                      <td>{{appartement.id}}</td>
                      <!--<td>{{appartement.numero_etage}}</td>
                      <td>{{appartement.numero_appartement}}</td>-->
                      <td>{{(appartement.numero)}}</td>
                      <td>{{appartement.superficie}} m²</td>
                      <td>{{(appartement.nbr_chambre)}}</td>
                      <td>{{appartement.prix_previsionnel}} XOF</td>
                       <td>{{appartement.type}}</td>
                       <td>{{appartement.appartement_immeuble}}</td>
                      <td><span class="tag tag-success">{{convert(appartement.created_at)}}</span></td>
                      <td>
                          <button @click="editAppartement(appartement.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteAppartement(appartement.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Appartement":"Add New Appartement"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateAppartement() : createAppartement()">
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select  v-model="appartement.immeuble_id" id="immeuble_id" class="form-control">
                                            <option value="" hidden selected>Selectionner un immeuble</option>
                                            <option v-for="immeuble in immeubles" :key="immeuble.id" :value="immeuble.id" >{{immeuble.nom}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="appartement.numero_etage" id="numero_etage" placeholder="Numero d'etage de l'Appart..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="appartement.numero_appartement" id="numero_appartement" placeholder="Numero de l'Appart sur un etage..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="appartement.superficie" id="superficie" placeholder="Superficie de l'appartement..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="appartement.nbr_chambre" id="nbr_chambre" placeholder="Nombre de chambre de l'appartement..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="appartement.prix_previsionnel" id="prix_previsionnel" placeholder="Prix previsionnel de l'appartement..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-if="is_Editing">
                                        <div class="form-group">
                                            <select v-model="appartement.type" id="type" name="" class="form-control">
                                                <option value="" selected>Status de L'Appartement</option>
                                                <option value="Disponible">Disponible</option>
                                                <option value="vendu">Vendu</option>
                                            </select>
                                        </div>
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
                immeubles:[],
                appartements:[],
                appartement:{
                    immeuble_id:'',
                    numero_etage:'',
                    numero_appartement:'',
                    numero:'0',
                    superficie:'',
                    nbr_chambre:'',
                    prix_previsionnel:'',
                    type:''
                },
                
                edit_id:'',
                is_Editing:false,
            }
        },
        methods:{
          loadImmeubles(){
                axios.get('api/immeubles').then((immeubles)=>{
                    this.immeubles = immeubles.data;
                })
            },
            convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            newModal(){
                this.appartement={
                        immeuble_id:'',
                        numero_etage:'',
                        numero_appartement:'',
                        numero:'369',
                        superficie:'',
                        nbr_chambre:'',
                        prix_previsionnel:'',
                        type:'9'
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadAppartements(){
                axios.get('api/appartements').then((appartements)=>{
                    this.appartements = appartements.data;
                })
            },
            createAppartement(){
                let imd = document.querySelector("#immeuble_id").value;
                let ne = document.querySelector("#numero_etage").value;
                let na = document.querySelector("#numero_appartement").value;
                let su = document.querySelector("#superficie").value;
                let nc= document.querySelector("#nbr_chambre").value;
                let pp = document.querySelector("#prix_previsionnel").value;
                if(imd ==""||ne =="" ||na ==""|| su=="" || nc==""||pp==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/appartements`,this.appartement).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Appartement Ajouter avec success.','success') ;
                    this.loadAppartements();
                    this.appartement={
                        immeuble_id:'',
                        numero_etage:'',
                        numero_appartement:'',
                        numero:'',
                        superficie:'',
                        nbr_chambre:'',
                        prix_previsionnel:'',
                        type:''
                    }
                }).catch((err)=>{
                    Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                })
            },
            deleteAppartement(id){
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
                            axios.delete(`api/appartements/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Appartement a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadAppartements();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Appartement est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteAppartement
            editAppartement(id){
                axios.get(`api/appartements/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.appartement.immeuble_id = res.data.immeuble_id;
                    this.appartement.numero_etage = res.data.numero_etage;
                    this.appartement.numero_appartement = res.data.numero_appartement;
                    this.appartement.superficie = res.data.superficie;
                    this.appartement.nbr_chambre = res.data.nbr_chambre;
                    this.appartement.prix_previsionnel = res.data.prix_previsionnel;
                    this.appartement.type = res.data.type;
                    this.is_Editing = true;
                })
            },
            updateAppartement(){
                    axios.put(`api/appartements/${this.edit_id}`,this.appartement).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Appartemnt mise à jour avec success.','success')    
                        this.loadAppartements();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadImmeubles();
            this.loadAppartements();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
