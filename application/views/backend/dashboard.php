<section class="content">

  <div class="row">
    <div class="col-lg-4 col-12">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner" id="head-suhu">
          <h3 id="suhu"></h3>

          <p>Suhu</p>
        </div>
        <div class="icon">
          <i class="fas fa-temperature-low fa-2x"></i>
        </div>
        <a href="<?= base_url('Dashboard/rekap') ; ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="kelembapan"></h3>

          <p>Kelembapan</p>
        </div>
        <div class="icon">
          <i class="fas fa-thermometer-full fa-2x"></i>
        </div>
        <a href="<?= base_url('Dashboard/rekap') ; ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="asap"></h3>

          <p>Kepekatan Asap</p>
        </div>
        <div class="icon">
          <i class="fas fa-cloud fa-2x"></i>
        </div>
        <a href="<?= base_url('Dashboard/rekap') ; ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>

</section>

<script>

  function tampil(){
    $.ajax({
        url: "<?= base_url('Dashboard/dashboard_realtime')?>",
        dataType: 'json',
        success:function(result){
          
          $('#suhu').text(result["suhu"]);

          $('#suhu').append('<sup style="font-size: 20px">o</sup>');

          $('#kelembapan').text(result["kelembapan"] + " %");
          $('#asap').text(result["asap"] + " %");
          
          setTimeout(tampil, 2000); 
        }
    });
  }
  
  document.addEventListener('DOMContentLoaded',function(){
    tampil();
  });   

</script>