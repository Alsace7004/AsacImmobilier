<template>
    <div class="container">
        <page-title title="Les Contrats de Vente Definitifs"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Contrats de Vente Definitifs</h3>

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
                      <th>Prix_vente</th>
                      <th>Type_payement</th>
                      <th>Description_Appart</th>
                      <th>Acquereur</th>
                      <th>Directeur</th>
                      <th>Avocat</th>
                      <th>Promesse</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!contratventedefinitifs.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de Contrat de vente definitif disponible...</tr>
                    <tr v-for="contratventedefinitif in contratventedefinitifs" :key="contratventedefinitif.id">
                      <td>{{contratventedefinitif.id}}</td>
                      <td>{{contratventedefinitif.prix_vente}}</td>
                      <td>{{contratventedefinitif.type_payement}}</td>
                      <td>{{truncate(contratventedefinitif.description_appartement,25)}}</td>
                      <td>{{contratventedefinitif.signature_acquereur}}</td>
                      <td>{{contratventedefinitif.signature_directeur_commercial}}</td>
                      <td>{{contratventedefinitif.nom}} {{contratventedefinitif.prenom}}</td>
                      <td>{{contratventedefinitif.client_appartement_immeuble}}</td>
                      <td><span class="tag tag-success">{{convert(contratventedefinitif.created_at)}}</span></td>
                      <td>
                          <button @click="editContratVenteDefinitif(contratventedefinitif.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteContratVenteDefinitif(contratventedefinitif.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Contrat Vente":"Add New Contrat Vente"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateContratVenteDefinitif() : createContratVenteDefinitif()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="" v-model="contratventedefinitif.description_appartement" class="form-control" placeholder="Description de l'appartement..." id="description_appartement" cols="5" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="contratventedefinitif.prix_vente"  id="prix_vente" placeholder="prix de vente de l'appart..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                            <select  v-model="contratventedefinitif.type_payement" id="type_payement" class="form-control">
                                                <option value="" selected>Type de payement</option>
                                                <option value="Liquide" selected>Liquide</option>
                                                <option value="Espece" selected>Espece</option>
                                                <option value="Tmoney" selected>Tmoney</option>
                                                <option value="Flooz" selected>Flooz</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <select  v-model="contratventedefinitif.avocat_id" id="avocat_id" class="form-control">
                                                <option value="" hidden selected>Selectionner l'Avocat</option>
                                                <option v-for="avocat in avocats" :key="avocat.id" :value="avocat.id" >{{avocat.nom}} {{avocat.prenom}}</option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                            <select  v-model="contratventedefinitif.promesse_vente_id" id="promesse_vente_id" class="form-control">
                                                <option value="" hidden selected>Selectionner une promesse vente</option>
                                                <option v-for="promessevente in promesseventes" :key="promessevente.id" :value="promessevente.id" >{{promessevente.client_appartement_immeuble}}</option>
                                            </select>
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
                promesseventes:[],
                contratventedefinitifs:[],
                contratventedefinitif:{
                    avocat_id:'',
                    promesse_vente_id:'',
                    description_appartement:'',
                    prix_vente:'',
                    type_payement:'',
                    signature_acquereur:'0',
                    signature_directeur_commercial:'0'
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
                this.contratventedefinitif={
                        avocat_id:'',
                        promesse_vente_id:'',
                        description_appartement:'',
                        prix_vente:'',
                        type_payement:'',
                        signature_acquereur:'0',
                        signature_directeur_commercial:'0'
                }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadAvocats(){
                axios.get('api/avocats').then((avocats)=>{
                    this.avocats = avocats.data;
                })
            },
            loadPromesseVentesCIA(){
                axios.get('api/clientIA').then((promesseventes)=>{
                    this.promesseventes = promesseventes.data;
                })
            },
            loadContratVenteDefinitifs(){
                axios.get('api/contratVenteDefinitifs').then((contratventedefinitifs)=>{
                    this.contratventedefinitifs = contratventedefinitifs.data;
                })
            },
            createContratVenteDefinitif(){
                    let da = document.querySelector("#description_appartement").value;
                    let pv = document.querySelector("#prix_vente").value;
                    let av_id = document.querySelector("#avocat_id").value;
                    let pv_id = document.querySelector("#promesse_vente_id").value;
                    let tp = document.querySelector("#type_payement").value;
                    if(da ==""||pv ==""||av_id ==""||pv_id ==""||tp ==""){
                        Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                        return;
                    }
                    axios.post('api/contratVenteDefinitifs',this.contratventedefinitif).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Contrat de vente Ajouter avec success.','success') ;
                    this.loadContratVenteDefinitifs();
                    this.contratventedefinitif={
                        avocat_id:'',
                        promesse_vente_id:'',
                        description_appartement:'',
                        prix_vente:'',
                        type_payement:'',
                        signature_acquereur:'0',
                        signature_directeur_commercial:'0'
                    }
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    });
            },
            deleteContratVenteDefinitif(id){
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
                            axios.delete(`api/contratVenteDefinitifs/${id}`).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'Le Contrat de vente a été supprimé(e).',
                                    'success'
                                    )
                                this.loadContratVenteDefinitifs();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Contrat de vente est toujours disponible !!!','error')
                        }
                })//first Then
            },//deleteSignature
             editContratVenteDefinitif(id){
                axios.get(`api/contratVenteDefinitifs/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.contratventedefinitif.avocat_id = res.data.avocat_id;
                    this.contratventedefinitif.promesse_vente_id = res.data.promesse_vente_id;
                    this.contratventedefinitif.description_appartement = res.data.description_appartement;
                    this.contratventedefinitif.prix_vente = res.data.prix_vente;
                    this.contratventedefinitif.type_payement = res.data.type_payement;
                    this.is_Editing = true;
                })
            },
            updateContratVenteDefinitif(){
                    axios.put(`api/contratVenteDefinitifs/${this.edit_id}`,this.contratventedefinitif).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Contrat de vente mise à jour avec success.','success')    
                        this.loadContratVenteDefinitifs();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                    })
            },
        },
        created(){
            this.loadAvocats();
            this.loadPromesseVentesCIA()
            this.loadContratVenteDefinitifs();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
