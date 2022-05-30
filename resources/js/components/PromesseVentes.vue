<template>
    <div class="container">
        <page-title title="Les promesses de vente"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Promesses de vente</h3>

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
                      <th>TauxTVA</th>
                      <th>Prix_HT</th>
                      <th>Prix_TTC</th>
                      <th>Avance</th>
                      <th>Rest à payer</th>
                      <th>Ristourne</th>
                      <!--<th>Etat</th>-->
                      <th>Appartements</th>
                      <th>Clients</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="promessevente in promesseventes" :key="promessevente.id">
                      <td>{{promessevente.id}}</td>
                      <td>{{promessevente.tauxTVA}}%</td>
                      <td>{{promessevente.prixVenteDefinitifHT}} XOF</td>
                      <td>{{(promessevente.prixVenteDefinitifTTC)}} XOF</td>
                      <td>{{promessevente.avance}} XOF</td>
                      <td>{{(promessevente.prixVenteDefinitifTTC - promessevente.avance)>0 ?(promessevente.prixVenteDefinitifTTC - promessevente.avance):'0'}} XOF</td>
                      <td>{{(promessevente.avance>promessevente.prixVenteDefinitifTTC)?(promessevente.avance-promessevente.prixVenteDefinitifTTC):'0'}} XOF</td>
                        <!--<td>{{promessevente.etat}}</td>-->
                       <td>{{promessevente.appartement_immeuble}}</td>
                       <td>{{promessevente.nom}} {{promessevente.prenom1}}</td>
                      <td><span class="tag tag-success">{{convert(promessevente.created_at)}}</span></td>
                      <td>
                          <button @click="payPromesseVente(promessevente.id)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addNewPay">Pay</button>
                          <button @click="editPromesseVente(promessevente.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deletePromesseVente(promessevente.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Promesse de vente":"Add New Promesse de vente"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updatePromesseVente() : createPromesseVente()">
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" v-model="promessevente.tauxTVA"  id="tauxTVA" placeholder="TVA de la promesse de vente..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="promessevente.prixVenteDefinitifHT" id="prixVenteDefinitifHT" placeholder="Prix Hors Taxe de la promesse de vente..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="promessevente.avance" id="avance" placeholder="Avance à payer..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select  v-model="promessevente.client_id" id="client_id" class="form-control">
                                            <option value="" hidden selected>Selectionner le client</option>
                                            <option v-for="client in clients" :key="client.id" :value="client.id" >{{client.nom}} {{client.prenom1}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select  v-model="promessevente.appartement_id" id="appartement_id" class="form-control">
                                            <option value="" hidden selected>Selectionner un Appart</option>
                                            <option v-for="appartement in appartements" :key="appartement.id" :value="appartement.id">{{appartement.appartement_immeuble}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-if="is_Editing">
                                        <div class="form-group">
                                            <select v-model="promessevente.etat" id="etat" name="" class="form-control">
                                                <option value="">Status de Promesse Vente</option>
                                                <option value="1">En Cours</option>
                                                <option value="0">Annuler</option>
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
        <!--------------------------------------------------------------------------------------->
                            <!-- Modal -->
                            <div class="modal fade" id="addNewPay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel" >Ajouter un Payement</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form  @submit.prevent="createPayPromesseVente">
                                            <div class="modal-body">
                                                        <div class="form-group">
                                                            <input type="text" v-model="promessevente.avance" id="avance" placeholder="Montant payement..." class="form-control">
                                                        </div>
                                            </div>
                                        
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button   type="submit" class="btn btn-primary">Add</button>
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
                promesseventes:[],
                promessevente:{
                    client_id:'',
                    appartement_id:'',
                    tauxTVA:'20',
                    prixVenteDefinitifHT:'',
                    prixVenteDefinitifTTC:'2',
                    avance:'',
                    etat:'11',
                },
                edit_id:'',
                is_Editing:false,
                pay_id:'',
            }
        },
        methods:{
            convert(jour){
                let  date =  new Date(jour);
                return  date.toDateString() // "sun nov 29 2020 "
            },
            newModal(){
                this.promessevente={
                        client_id:'',
                        appartement_id:'',
                        tauxTVA:'20',
                        prixVenteDefinitifHT:'',
                        prixVenteDefinitifTTC:'0',
                        avance:'',
                        etat:"10",
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
            loadPromesseVentes(){
                axios.get('api/promesseVentes').then((promesseventes)=>{
                    this.promesseventes = promesseventes.data;
                })
            },
            createPromesseVente(){
                let cid = document.querySelector("#client_id").value;
                let ap = document.querySelector("#appartement_id").value;
                let tva = document.querySelector("#tauxTVA").value;
                let ht = document.querySelector("#prixVenteDefinitifHT").value;
                let av = document.querySelector("#avance").value;
                
                if(cid==""||ap =="" ||tva ==""||ht==""||av==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/promesseVentes`,this.promessevente).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Promesse de vente Ajouter avec success.','success') ;
                    this.loadPromesseVentes();
                    this.promessevente={
                        client_id:'',
                        appartement_id:'',
                        tauxTVA:'',
                        prixVenteDefinitifHT:'',
                        prixVenteDefinitifTTC:'0',
                        avance:'',
                        etat:'0',
                    }
                }).catch((err)=>{
                    /*console.log('valeur de la err.response:',err.response.data.Message)
                    console.log('valeur de la err.response:',err.response.data.AvancePermis)*/
                   // Swal.fire('Error !!!',`Une Erreur Survenue !!! \n\n ${err.response.data.Message} \n\n L'avance doit etre >= ${err.response.data.AvancePermis} XOF `,'error')
                   if(err.response.data.Message){
                       Swal.fire('Error !!!',`Une Erreur Survenue !!! \n\n ${err.response.data.Message} \n\n L'avance doit etre >= ${err.response.data.AvancePermis} XOF `,'error')
                   }else if(err.response.data.errors.appartement_id){
                        Swal.fire('Error !!!',`Cette appartement est deja pris :${err.response.data.errors.appartement_id}`,'error')
                   }else if(err.response.message){
                        Swal.fire('Error !!!',`duplication de user pas possible`,'error')
                   }else{
                         Swal.fire('Error !!!',`Une erreur est survenue`,'error')
                   }
                   
                })
            },
            deletePromesseVente(id){
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
                            axios.delete(`api/promesseVentes/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'La Promesse de vente a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadPromesseVentes();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Promesse de vente est toujours disponible !!!','error')
                        }
                })//first Then
            },//deletePromesseVente
            editPromesseVente(id){
                axios.get(`api/promesseVentes/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.promessevente.client_id = res.data.client_id;
                    this.promessevente.appartement_id = res.data.appartement_id;
                    this.promessevente.tauxTVA = res.data.tauxTVA;
                    this.promessevente.prixVenteDefinitifHT = res.data.prixVenteDefinitifHT;
                    this.promessevente.prixVenteDefinitifTTC = res.data.prixVenteDefinitifTTC;
                    this.promessevente.avance = res.data.avance;
                    this.promessevente.etat = res.data.etat;
                    this.is_Editing = true;
                })
            },
            updatePromesseVente(){
                    axios.put(`api/promesseVentes/${this.edit_id}`,this.promessevente).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Promesse de vente mise à jour avec success.','success')    
                        this.loadPromesseVentes();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!',`Une Erreur Survenue !!! \n\n ${err.response.data.Message} \n\n L'avance doit etre >= ${err.response.data.AvancePermis} XOF `,'error')
                    })
            },
            payPromesseVente(id){
               // alert(id)
                this.pay_id=id;
                //alert(this.pay_id)
            },
            createPayPromesseVente(){
                let av = document.querySelector("#avance").value;
                if(av==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/promesseVentePayements/${ this.pay_id}`,this.promessevente).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Payement sur cette Promesse de vente Effectuer avec success.','success') ;
                    this.loadPromesseVentes();
                    this.promessevente={
                        client_id:'',
                        appartement_id:'',
                        tauxTVA:'',
                        prixVenteDefinitifHT:'',
                        prixVenteDefinitifTTC:'',
                        avance:'',
                        etat:'',
                    }
                }).catch((err)=>{
                    Swal.fire('Avertissement !!!',`Une Erreur Survenue !!! \n\n ${err.response.data.message} XOF `,'warning');
                })
            }
        },
        created(){
            this.loadClients();
            this.loadAppartements();
            this.loadPromesseVentes();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
