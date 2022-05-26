<template>
    <div class="container">
        <page-title title="Les Avocats"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Avocats</h3>

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
                      <th>Telephone1</th>
                      <th>Telephone2</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="avocat in avocats" :key="avocat.id">
                      <td>{{avocat.id}}</td>
                      <td>{{avocat.nom}}</td>
                      <td>{{avocat.prenom}}</td>
                      <td>{{avocat.adresse}}</td>
                      <td>{{avocat.telephone1}}</td>
                       <td>{{avocat.telephone2}}</td>
                      <td><span class="tag tag-success">{{convert(avocat.created_at)}}</span></td>
                      <td>
                          <button @click="editAvocat(avocat.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteAvocat(avocat.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Avocat":"Add New Avocat"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateAvocat() : createAvocat()">
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.num_autorisation"  id="num_autorisation" placeholder="Numero d'autorisation de l'Avocat..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.nom" id="nom" placeholder="Nom de l'Avocat..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.prenom" id="prenom" placeholder="Prenom de l'Avocat..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.adresse" id="adresse" placeholder="Adresse de l'Avocat..." class="form-control">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.telephone1" id="telephone1" placeholder="Telephone1 de l'Avocat..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.telephone2" id="telephone2" placeholder="Telephone2 de l'Avocat..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="avocat.telephone3" id="telephone3" placeholder="Telephone3 de l'Avocat..." class="form-control">
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
                avocats:[],
                avocat:{
                    num_autorisation:'',
                    nom:'',
                    prenom:'',
                    adresse:'',
                    telephone1:'',
                    telephone2:'',
                    telephone3:'',
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
                this.avocat={
                        num_autorisation:'',
                        nom:'',
                        prenom:'',
                        adresse:'',
                        telephone1:'',
                        telephone2:'',
                        telephone3:'',
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadAvocats(){
                axios.get('api/avocats').then((avocats)=>{
                    this.avocats = avocats.data;
                })
            },
            createAvocat(){
                let na = document.querySelector("#num_autorisation").value;
                let nm = document.querySelector("#nom").value;
                let pr = document.querySelector("#prenom").value;
                let ad = document.querySelector("#adresse").value;
                let tel1 = document.querySelector("#telephone1").value;
                let tel2 = document.querySelector("#telephone2").value;
                if(na ==""||nm =="" ||pr ==""|| ad=="" || tel1==""||tel2==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/avocats`,this.avocat).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Avocat Ajouter avec success.','success') ;
                    this.loadAvocats();
                    this.avocat={
                        num_autorisation:'',
                        nom:'',
                        prenom:'',
                        adresse:'',
                        telephone1:'',
                        telephone2:'',
                        telephone3:'',
                    }
                }).catch((err)=>{
                    Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                })
            },
            deleteAvocat(id){
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
                            axios.delete(`api/avocats/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Avocat a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadAvocats();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Avocat est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteAvocat
            editAvocat(id){
                axios.get(`api/avocats/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.avocat.num_autorisation = res.data.num_autorisation;
                    this.avocat.nom = res.data.nom;
                    this.avocat.prenom = res.data.prenom;
                    this.avocat.adresse = res.data.adresse;
                    this.avocat.telephone1 = res.data.telephone1;
                    this.avocat.telephone2 = res.data.telephone2;
                    this.avocat.telephone3 = res.data.telephone3;
                    this.is_Editing = true;
                })
            },
            updateAvocat(){
                    axios.put(`api/avocats/${this.edit_id}`,this.avocat).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Avocat(e) mise à jour avec success.','success')    
                        this.loadAvocats();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadAvocats();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
