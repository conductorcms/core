<script>window.modules = [];</script>

@foreach($modules as $module)
    <script>
        window.modules.push('<?= $module ?>');
    </script>
 @endforeach