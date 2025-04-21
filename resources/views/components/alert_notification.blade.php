@if (session('error'))
    <div id="errorAlert" class="alert alert-danger">
        {{ session('error') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('errorAlert').style.display = 'none';
        }, 10000); //(10000 milidetik = 10 detik)
    </script>
    <?php session()->forget('error'); ?>
@endif

@if (session('data'))
    <div id="successAlert" class="alert alert-success">
        {{ session('data') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 10000); //(10000 milidetik = 10 detik)
    </script>
    <?php session()->forget('error'); ?>
@endif

@if (session('success'))
    <div id="successAlert" class="alert alert-success">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 10000); //(10000 milidetik = 10 detik)
    </script>
    <?php session()->forget('success'); ?>
@endif