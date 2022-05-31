<template>
    <div class="container">
        <page-title title="Les payements"/>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success btn-sm mb-3" @click="newModal" data-toggle="modal" data-target="#addNew">Ajouter</button>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Payements</h3>

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
                      <th>Montant</th>
                      <th>Promesse Vente</th>
                      <th>Created_at</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="!payements.length" class="text-center text-danger" style="font-weight:bolder;margin:0px auto">Pas de Payements disponible...</tr>
                    <tr v-for="payement in payements" :key="payement.id">
                      <td>{{payement.id}}</td>
                      <td>{{payement.prix_payer}}</td>
                      <td>{{payement.appartement_immeuble}}</td>
                      <td><span class="tag tag-success">{{convert(payement.created_at)}}</span></td>
                      <td>
                          <button @click="editPayement(payement.id)" class="btn btn-success btn-sm">Edit</button>
                          <button @click="deletePayement(payement.id)" class="btn btn-danger btn-sm">Delete</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{is_Editing ?"Update Payement":"Add New Payement"}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="is_Editing ? updatePayement() : createPayement()">
                        <div class="modal-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" v-model="payement.prix_payer"  id="prix_payer" placeholder="Montant à payer..." class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <select  v-model="payement.promesse_vente_id" id="promesse_vente_id" class="form-control">
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
                promesseventes:[],
                payements:[],
                payement:{
                    promesse_vente_id:'',
                    prix_payer:''
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
            createPayement(){
                let pp = document.querySelector("#prix_payer").value;
                let pvi = document.querySelector("#promesse_vente_id").value;
                if(pp ==""||pvi ==""){
                    Toast.fire({icon: 'error',title: 'veuillez remplir tous les champs !!!'});
                    return;
                }
                axios.post(`api/payements`,this.payement).then(()=>{
                    //$('#addNew').modal('hide'); 
                    Swal.fire('Created!','Payements Ajouter avec success.','success') ;
                    this.loadPayements();
                    this.payement={
                        promesse_vente_id:'',
                        prix_payer:''
                    }
                }).catch((err)=>{
                    Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                })
            },
            loadPromesseVentesCIA(){
                axios.get('api/clientIA').then((promesseventes)=>{
                    this.promesseventes = promesseventes.data;
                })
            },
            loadPayements(){
                axios.get('api/payements').then((payements)=>{
                    this.payements = payements.data;
                })
            },
            deletePayement(id){
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
                            axios.delete(`api/payements/${id}`).then(()=>{
                            
                                    Swal.fire(
                                    'Deleted!',
                                    'Le Payement a été supprimé(e).',
                                    'success'
                                    )
                                
                                this.loadPayements();
                            }).catch((err)=>{
                                Swal.fire('Error !!!','Une Erreur Survenue !!!','error')
                            })
                        }else{
                            Swal.fire('Cancelled !!!','Votre Payement est toujours disponible !!!','error')
                        }
                })//first Then
            },//deletePayement
            editPayement(id){
                axios.get(`api/payements/${id}`).then((res)=>{
                    $('#addNew').modal('show');
                    this.edit_id = res.data.id;
                    this.payement.promesse_vente_id = res.data.promesse_vente_id;
                    this.payement.prix_payer = res.data.prix_payer;
                    this.is_Editing = true;
                })
            },
            updatePayement(){
                    axios.put(`api/payements/${this.edit_id}`,this.payement).then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!','Payement mise à jour avec success.','success')    
                        this.loadPayements();
                        this.edit_id = "";
                        this.is_Editing = false;
                    }).catch((err)=>{
                        Swal.fire('Error !!!',`Une Erreur Survenue !!!`,'error')
                    })
            },
        },
        created(){
            this.loadPayements();
            this.loadPromesseVentesCIA();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
