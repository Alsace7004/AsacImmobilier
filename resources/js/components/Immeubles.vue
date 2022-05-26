<template>
    <div class="container">
        <page-title title="Les Immeubles"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des immeubles</h3>

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
                      <th>Nbr d'Etages</th>
                      <th>Nbr d'Appartements</th>
                      <th>Adresse</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="immeuble in immeubles" :key="immeuble.id">
                      <td>{{immeuble.id}}</td>
                      <td>{{immeuble.nom}}</td>
                      <td>{{immeuble.nbr_etages}}</td>
                      <td>{{immeuble.nbr_appartement}}</td>
                      <td>{{(immeuble.adresse)}}</td>
                      <td><span class="tag tag-success">{{convert(immeuble.created_at)}}</span></td>
                      <td>
                          <button @click="editImmeuble(immeuble.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteImmeuble(immeuble.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Immeuble":"Add New Immeuble"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateImmeuble() : createImmeuble()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" v-model="immeuble.nom"  id="nom" placeholder="Nom de l'immeuble..." class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="immeuble.adresse" id="adresse" placeholder="Adresse de l'immeuble..." class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="immeuble.nbr_appartement" id="nbr_appartement" placeholder="Nombre d'Appartement de l'immeuble..." class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="immeuble.nbr_etages" id="nbr_etages" placeholder="Nombre d'Etages l'immeuble..." class="form-control">
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
                immeuble:{
                    nom:'',
                    adresse:'',
                    nbr_appartement:'',
                    nbr_etages:''
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
                this.immeuble={
                        nom:'',
                        adresse:'',
                        nbr_appartement:'',
                        nbr_etages:''
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadImmeubles(){
                axios.get('api/immeubles').then((immeubles)=>{
                    this.immeubles = immeubles.data;
                })
            },
            createImmeuble(){
                let nm = document.querySelector("#nom").value;
                let ad = document.querySelector("#adresse").value;
                let na = document.querySelector("#nbr_appartement").value;
                let ne = document.querySelector("#nbr_etages").value;
                if(nm =="" || ad=="" || na==""||ne==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/immeubles`,this.immeuble).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Immeuble créer avec success.','success') ;
                    this.loadImmeubles();

                    this.immeuble.nom ="";
                    this.immeuble.adresse="";
                    this.immeuble.nbr_appartement="";
                    this.immeuble.nbr_etages="";
                }).catch((err)=>{
                    Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                })
            },
            deleteImmeuble(id){
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
                            axios.delete(`api/immeubles/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Immeuble a été supprimée.',
                                    'success'
                                    )
                                
                                this.loadImmeubles();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Immeuble est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteImmeuble
            editImmeuble(id){
                axios.get(`api/immeubles/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.immeuble.nom = res.data.nom;
                    this.immeuble.adresse = res.data.adresse;
                    this.immeuble.nbr_appartement = res.data.nbr_appartement;
                    this.immeuble.nbr_etages = res.data.nbr_etages;
                    this.is_Editing = true;
                })
            },
            updateImmeuble(){
                    axios.put(`api/immeubles/${this.edit_id}`,this.immeuble).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Immeuble mise à jour avec success.','success')    
                        this.loadImmeubles();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadImmeubles();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
