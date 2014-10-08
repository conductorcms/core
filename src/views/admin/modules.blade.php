@extends('conductor::admin.templates.master')

@section('content')
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Modules
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Modules</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Author</th>
							<th>Version</th>
							<th>Installed?</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($modules as $module)
							<tr>
								<td>{{ $module->display_name }}</td>
								<td>{{ $module->description }}</td>
								<td>{{ $module->author }}</td>
								<td>{{ $module->version }}</td>
								<td>{{ $module->installed }}</td>
								<td>
									<button class="btn btn-primary">Install</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

@stop

@section('footer')

