<template>
    <div class="container">
        <page-title title="Les Signatures"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Signature</h3>

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
                      <th>Avocat</th>
                      <th>Promesse Vente</th>
                      <th>Signature Acquereur</th>
                      <th>Signature Directeur Commercial</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="signature in signatures" :key="signature.id">
                      <td>{{signature.id}}</td>
                      <td>{{signature.avocat_id}}</td>
                      <td>{{signature.promesse_vente_id}}</td>
                      <td>{{(signature.signaturePromesseAcquereur)}}</td>
                      <td>{{signature.signaturePromesseDirecteurCommercial}}</td>
                      <td><span class="tag tag-success">{{convert(signature.created_at)}}</span></td>
                      <td>
                          <button @click="editSignature(signature.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deleteSignature(signature.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Signature":"Add New Signature"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updateSignature() : createSignature()">
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <select  v-model="signature.avocat_id" id="client_id" class="form-control">
                                            <option value="" hidden selected>Selectionner l'Avocat</option>
                                            <option v-for="avocat in avocats" :key="avocat.id" :value="avocat.id" >{{avocat.nom}} {{avocat.prenom}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select  v-model="signature.promesse_vente_id" id="promesse_vente_id" class="form-control">
                                            <option value="" hidden selected>Selectionner une promesse vente</option>
                                            <option v-for="promessevente in promesseventes" :key="promessevente.id" :value="promessevente.id" >{{promessevente.client_appartement_immeuble}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" v-model="signature.signaturePromesseAcquereur" id="signaturePromesseAcquereur" placeholder="signature de Promesse de l'Acquereur..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" v-model="signature.signaturePromesseDirecteurCommercial" id="signaturePromesseDirecteurCommercial" placeholder="signature de la Promesse du Directeur Commercial..." class="form-control">
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
                promesseventes:[],
                avocats:[],
                signatures:[],
                signature:{
                    avocat_id:'',
                    promesse_vente_id:'',
                    signaturePromesseAcquereur:'',
                    signaturePromesseDirecteurCommercial:''
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
                this.payement={
                        promesse_vente_id:'',
                        prix_payer:'',
                    }
                this.is_Editing = false;
                $('#addNew').modal('show');
            },
            loadPromesseVentesCIA(){
                axios.get('api/clientIA').then((promesseventes)=>{
                    this.promesseventes = promesseventes.data;
                })
            },
            loadAvocats(){
                axios.get('api/avocats').then((avocats)=>{
                    this.avocats = avocats.data;
                })
            },
            loadSignatures(){
                axios.get('api/signatures').then((signatures)=>{
                    this.signatures = signatures.data;
                })
            },
        },
        created(){
            this.loadAvocats();
            this.loadSignatures();
            this.loadPromesseVentesCIA();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
