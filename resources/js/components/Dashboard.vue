<template>
    <div class="container">
            <page-title title="Le Dashboard"/>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info">
                            <div class="inner">
                              <h3>{{this.users}}</h3>
              
                              <p>Users</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-users"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3>{{this.immeubles}}</h3>
              
                              <p>Immeubles</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-building"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning">
                            <div class="inner">
                              <h3>{{this.appartements}}</h3>
              
                              <p>Appartements</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-house-user"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger">
                            <div class="inner">
                              <h3>{{this.clients}}</h3>
              
                              <p>Clients</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-users"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info">
                            <div class="inner">
                              <h3>150</h3>
              
                              <p>Visites</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-search-location"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3>53<sup style="font-size: 20px">%</sup></h3>
              
                              <p>Promesses de vente</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-edit"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning">
                            <div class="inner">
                              <h3>44</h3>
              
                              <p>Avocats</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-balance-scale"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger">
                            <div class="inner">
                              <h3>65</h3>
              
                              <p>Signatures</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-file-signature"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info">
                            <div class="inner">
                              <h3>150</h3>
              
                              <p>Desistements</p>
                            </div>
                            <div class="icon">
                              <i class="ion far fa-image"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3>53<sup style="font-size: 20px">%</sup></h3>
              
                              <p>Payements</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning">
                            <div class="inner">
                              <h3>44</h3>
              
                              <p>Contrat de vente Definitif</p>
                            </div>
                            <div class="icon">
                              <i class="ion far fa-sticky-note"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger">
                            <div class="inner">
                              <h3>65</h3>
              
                              <p>Proces Verbals</p>
                            </div>
                            <div class="icon">
                              <i class="ion fas fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                    </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
            immeubles:'',
            appartements:'',
            clients:'',
            users:'',
          }
        },
        methods:{
           loadCountImmeubles(){
                axios.get('api/immeublesNumb').then((immeubles)=>{
                  this.immeubles = immeubles.data[0].nbr_total_immeuble;
                })
            },
            loadCountAppartements(){
                axios.get('api/appartementsNumb').then((appartements)=>{
                  this.appartements = appartements.data[0].nbr_total_appartement;
                })
            },
            loadCountClients(){
                axios.get('api/clientsNumb').then((clients)=>{
                  this.clients = clients.data[0].nbr_total_client;
                })
            },
            loadCountUsers(){
                axios.get('api/usersNumb').then((users)=>{
                  this.users = users.data[0].nbr_total_user;
                })
            },
        },
        created(){
          this.loadCountImmeubles();
          this.loadCountAppartements();
          this.loadCountClients();
          this.loadCountUsers();
        },
        mounted() {
            console.log('Component mounted.')
        }

        
    }
</script>
