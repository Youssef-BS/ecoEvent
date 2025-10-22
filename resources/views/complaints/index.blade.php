<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donations Management</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --success-color: #4cc9f0;
      --warning-color: #f72585;
      --info-color: #4895ef;
      --light-color: #f8f9fa;
      --dark-color: #212529;
    }

    body {
      background-color: #f5f7fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card-complaint-type {
      transition: all 0.3s ease;
      cursor: pointer;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      height: 100%;
    }

    .card-complaint-type:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .card-complaint-type.active {
      border: 2px solid var(--primary-color);
    }

    .complaint-type-icon {
      font-size: 2.5rem;
      margin-bottom: 15px;
    }

    .complaint-table {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-in-progress {
      background-color: #cce7ff;
      color: #004085;
    }

    .status-resolved {
      background-color: #d4edda;
      color: #155724;
    }

    .severity-high {
      color: #dc3545;
      font-weight: bold;
    }

    .severity-medium {
      color: #ffc107;
      font-weight: bold;
    }

    .severity-low {
      color: #28a745;
      font-weight: bold;
    }

    .modal-header {
      background-color: var(--primary-color);
      color: white;
    }

    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-primary:hover {
      background-color: var(--secondary-color);
      border-color: var(--secondary-color);
    }

    .table thead {
      background-color: var(--primary-color);
      color: white;
    }

    .table tbody tr {
      transition: all 0.2s ease;
    }

    .table tbody tr:hover {
      background-color: rgba(67, 97, 238, 0.05);
    }

    .complaint-count {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 0;
    }

    .complaint-type-title {
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .complaint-type-subtitle {
      font-size: 0.8rem;
      color: #6c757d;
    }

    .empty-state {
      text-align: center;
      padding: 3rem;
      color: #6c757d;
    }

    .img-thumbnail {
      max-width: 100%;
      height: auto;
      border: 1px solid #dee2e6;
      border-radius: 0.375rem;
      padding: 0.25rem;
      background-color: #fff;
    }

    /* Style for pending complaints (status 0) */
    .complaint-pending {
      background-color: #fff5f5 !important;
      border-left: 4px solid #dc3545;
    }

    /* Style for resolved complaints (status 1) */
    .complaint-resolved {
      background-color: #d2f8d2ff !important;
      border-left: 4px solid #28a745;
    }

    /* Ensure the hover effect still works with our new styles */
    .complaint-pending:hover {
      background-color: #ffe6e6 !important;
    }

    .complaint-resolved:hover {
      background-color: #e6ffe6 !important;
    }
  </style>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/favicon.svg" type="x-icon" />
  <title>Eco Event</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- ========== All CSS files linkup ========= -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/lineicons.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/fullcalendar.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/main.css')}}" />
</head>

@extends('admin.layouts.dashboard')

@section('content')
    <div class="container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="h3 fw-bold text-dark">Complaints Management</h1>
          <p class="text-muted mb-0">Manage all Issues</p>
        </div>
      </div>
    </div>

    <!-- Complaint Type Cards -->
    <div class="container mb-2">
      <div class="row g-3">
        @php
        // Calculate counts for each complaint type
        $paymentCount = $complaints->where('type', 'payment process')->count();
        $eventCount = $complaints->where('type', 'event')->count();
        $postingCount = $complaints->where('type', 'posting')->count();
        $websiteCount = $complaints->where('type', 'website')->count();
        $storeCount = $complaints->where('type', 'store')->count();
        $totalCount = $complaints->count();
        @endphp

        <div class="col-md-2 col-2">
          <div class="card card-complaint-type active" data-type="payment process">
            <div class="card-body text-center py-4">
              <h5 class="complaint-count">{{ $paymentCount }}</h5>
              <p class="complaint-type-title">Payment Process</p>
              <p class="complaint-type-subtitle">Payment related issues</p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card card-complaint-type" data-type="event">
            <div class="card-body text-center py-4">
              <h5 class="complaint-count">{{ $eventCount }}</h5>
              <p class="complaint-type-title">Event</p>
              <p class="complaint-type-subtitle">Event related issues</p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card card-complaint-type" data-type="posting">
            <div class="card-body text-center py-4">
              <h5 class="complaint-count">{{ $postingCount }}</h5>
              <p class="complaint-type-title">Posting</p>
              <p class="complaint-type-subtitle">Content posting issues</p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card card-complaint-type" data-type="website">
            <div class="card-body text-center py-4">
              <h5 class="complaint-count">{{ $websiteCount }}</h5>
              <p class="complaint-type-title">Website</p>
              <p class="complaint-type-subtitle">Website functionality</p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card card-complaint-type" data-type="store">
            <div class="card-body text-center py-4">
              <h5 class="complaint-count">{{ $storeCount }}</h5>
              <p class="complaint-type-title">Store</p>
              <p class="complaint-type-subtitle">Store related issues</p>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="card card-complaint-type bg-primary text-white" data-type="all">
            <div class="card-body text-center py-4">
              <h5 class="complaint-count">{{ $totalCount }}</h5>
              <p class="complaint-type-title">All Complaints</p>
              <p class="complaint-type-subtitle">View all issues</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Complaints Table -->
    <div class="container">
      <div class="card complaint-table">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0" id="tableTitle">Payment Process Complaints</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th width="15%">User</th>
                  <th width="20%">Description</th>
                  <th width="10%">Severity</th>
                  <th width="10%">Image</th>
                  <th width="15%">Date</th>
                  <th width="10%">Status</th>
                  <th width="15%">Actions</th>
                </tr>
              </thead>
              <tbody id="complaintsTableBody">
                <!-- Empty State Row (initially hidden) -->
                <tr id="emptyStateRow" style="display: none;">
                  <td colspan="8" class="text-center py-4">
                    <div class="empty-state">
                      <i class="fas fa-inbox fa-3x mb-3"></i>
                      <h5>No complaints found</h5>
                      <p id="emptyStateText">There are no complaints at the moment.</p>
                    </div>
                  </td>
                </tr>

                <!-- Load ALL complaints initially -->
                @if($complaints->count() > 0)
                @foreach($complaints as $complaint)
                @php
                // Parse the created_at date safely
                $createdDate = $complaint->created_at instanceof \Carbon\Carbon
                ? $complaint->created_at
                : \Carbon\Carbon::parse($complaint->created_at);
                @endphp
                <tr class="complaint-row @if($complaint->status == 0) complaint-pending @else complaint-resolved @endif" data-type="{{ $complaint->type }}">
                  <td>#{{ $complaint->idComplaint }}</td>
                  <td>User #{{ $complaint->user_id }}</td>
                  <td>{{ Str::limit($complaint->description, 50) }}</td>
                  <td class="severity-{{ $complaint->severity }}">{{ ucfirst($complaint->severity) }}</td>
                  <td>
                    @if($complaint->image)
                    <span class="badge bg-success">With Image</span>
                    @else
                    <span class="badge bg-secondary">No Image</span>
                    @endif
                  </td>
                  <td>{{ $createdDate->format('Y-m-d') }}</td>
                  <td>
                    <span class="status-badge status-{{ $complaint->status }}">
                      {{ $complaint->status == 0 ? 'Pending' : 'Resolved' }}
                    </span>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-outline-dark reply-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#replyModal"
                      data-id="{{ $complaint->idComplaint }}"
                      data-user="User #{{ $complaint->user_id }}"
                      data-type="{{ $complaint->type }}"
                      data-description="{{ $complaint->description }}"
                      data-reply="{{ $complaint->reply ?? '' }}"
                      data-image="{{ $complaint->image ? asset('storage/' . $complaint->image) : '' }}"
                      data-created-at="{{ $createdDate->format('Y-m-d') }}">
                      <i class="fas fa-reply me-2"></i> Reply
                    </button>
                  </td>
                </tr>
                @endforeach
                @else
                <!-- If there are no complaints at all, show empty state -->
                <tr id="emptyStateRow">
                  <td colspan="8" class="text-center py-4">
                    <div class="empty-state">
                      <i class="fas fa-inbox fa-3x mb-3"></i>
                      <h5>No complaints found</h5>
                      <p id="emptyStateText">There are no complaints at the moment.</p>
                    </div>
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        @if($complaints->count() > 0)
        <div class="card-footer bg-white py-3">
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
              Showing <span id="visibleCount">{{ $complaints->where('type', 'payment process')->count() }}</span> of {{ $totalCount }} entries
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <form id="replyForm" method="POST">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="replyModalLabel">Reply to Complaint #<span id="complaintId">0</span></h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-4">
                <h6>Complaint Details</h6>
                <div class="card bg-light">
                  <div class="card-body">
                    <p><strong>User:</strong> <span id="complaintUser">-</span></p>
                    <p><strong>Type:</strong> <span id="complaintType">-</span></p>
                    <p><strong>Description:</strong> <span id="complaintDescription">-</span></p>
                    <p><strong>Reply:</strong> <span id="complaintReply">-</span></p>
                    <p><strong>Submitted:</strong> <span id="complaintDate">-</span></p>
                    <div id="complaintImageContainer" style="display: none;">
                      <strong>Image:</strong><br>
                      <img id="complaintImage" src="" alt="Complaint Image" class="img-thumbnail mt-2" style="max-height: 200px;">
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label for="replyMessage" class="form-label">Your Reply</label>
                <textarea class="form-control" id="replyMessage" name="reply" rows="6" placeholder="Type your response here..." required></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Send Reply</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Function to update visible count
      function updateVisibleCount() {
        const visibleRows = document.querySelectorAll('tbody tr.complaint-row:not([style*="display: none"])');
        document.getElementById('visibleCount').textContent = visibleRows.length;
      }

      // Handle complaint type card clicks
      document.querySelectorAll('.card-complaint-type').forEach(card => {
        card.addEventListener('click', function() {
          // Remove active class from all cards
          document.querySelectorAll('.card-complaint-type').forEach(c => {
            c.classList.remove('active');
          });

          // Add active class to clicked card
          this.classList.add('active');

          // Update table header based on selected type
          const type = this.getAttribute('data-type');
          const tableHeader = document.getElementById('tableTitle');

          if (type === 'all') {
            tableHeader.textContent = 'All Complaints';
          } else {
            tableHeader.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} Complaints`;
          }

          // Filter table rows based on selected type
          const allRows = document.querySelectorAll('tbody tr.complaint-row');
          let hasVisibleRows = false;

          allRows.forEach(row => {
            if (type === 'all' || row.getAttribute('data-type') === type) {
              row.style.display = '';
              hasVisibleRows = true;
            } else {
              row.style.display = 'none';
            }
          });

          // Show/hide empty state
          const emptyState = document.getElementById('emptyStateRow');
          if (hasVisibleRows) {
            emptyState.style.display = 'none';
          } else {
            emptyState.style.display = '';
            // Update empty state message
            const emptyStateMessage = emptyState.querySelector('#emptyStateText');
            if (type === 'all') {
              emptyStateMessage.textContent = 'There are no complaints at the moment.';
            } else {
              emptyStateMessage.textContent = `There are no ${type} complaints at the moment.`;
            }
          }

          // Update visible count
          updateVisibleCount();
        });
      });

      // Store current complaint ID
      let currentComplaintId = null;

      // Handle reply button clicks
      document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', function() {
          const complaintId = this.getAttribute('data-id');
          const complaintUser = this.getAttribute('data-user');
          const complaintType = this.getAttribute('data-type');
          const complaintDescription = this.getAttribute('data-description');
          const complaintReply = this.getAttribute('data-reply');
          const complaintDate = this.getAttribute('data-created-at');
          const complaintImage = this.getAttribute('data-image');

          // Store the complaint ID
          currentComplaintId = complaintId;

          document.getElementById('complaintId').textContent = complaintId;
          document.getElementById('complaintUser').textContent = complaintUser;
          document.getElementById('complaintType').textContent = complaintType;
          document.getElementById('complaintDescription').textContent = complaintDescription;
          document.getElementById('complaintReply').textContent = complaintReply || 'No reply yet';
          document.getElementById('complaintDate').textContent = complaintDate;

          // Update form action
          const form = document.getElementById('replyForm');
          form.action = `/complaints/${complaintId}/reply`;

          // Handle image display
          const imageContainer = document.getElementById('complaintImageContainer');
          const imageElement = document.getElementById('complaintImage');

          if (complaintImage && complaintImage !== '') {
            imageElement.src = complaintImage;
            imageContainer.style.display = 'block';
          } else {
            imageContainer.style.display = 'none';
          }
        });
      });

      // Handle form submission - simple validation
      document.getElementById('replyForm').addEventListener('submit', function(e) {
        const replyMessage = document.getElementById('replyMessage').value;

        if (replyMessage.trim() === '') {
          e.preventDefault();
          alert('Please enter a reply message');
          return;
        }

        if (!currentComplaintId) {
          e.preventDefault();
          alert('Error: No complaint selected');
          return;
        }
      });
    </script>

@endsection    

</html>