@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-6">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Semua Dokumen BA</h1>
        <div class="btn-group">
            <a href="?type=all" class="btn btn-outline-primary">Semua</a>
            <a href="?type=BAPB" class="btn btn-outline-success">BAPB</a>
            <a href="?type=BAPP" class="btn btn-outline-info">BAPP</a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Nomor Dokumen</th>
                            <th>Vendor</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokumenBa as $dokumen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge {{ $dokumen->jenis_dokumen == 'BAPB' ? 'bg-success' : 'bg-info' }}">
                                    {{ $dokumen->jenis_dokumen }}
                                </span>
                            </td>
                            <td>{{ \$dokumen->nomor_kontrak ?? 'N/A' }}</td>
                            <td>{{ \$dokumen->nama_vendor ?? 'N/A' }}</td>
                            <td>
                                @if($dokumen->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($dokumen->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($dokumen->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $dokumen->status }}</span>
                                @endif
                            </td>
                            <td>{{ $dokumen->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('vendor.dokumenba.show', $dokumen->id) }}" 
                                   class="btn btn-sm btn-info">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data dokumen</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $dokumenBa->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
