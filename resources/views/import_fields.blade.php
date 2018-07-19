@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Import Fields </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('posts.import.process') }}">
                        @csrf
                        
                        <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

                        <table class="table">
                            @foreach ($csv_data as $row)
                                <tr>
                                    @foreach ($row as $key => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                @foreach ($csv_data[0] as $key => $value)
                                    <td>
                                        <select name="fields[{{ $key }}]">
                                            @foreach (config('app.db_fields') as $db_field)
                                                <option value="{{ $loop->index }}">{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    
                        <button type="submit" class="btn btn-primary">
                            Import Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
