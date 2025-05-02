<?php
require_once './Auth/auth_check.php';
ob_start();
include __DIR__ . '/../conf.php';

// Handle Deletion
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_query = "DELETE FROM users WHERE id = $delete_id";
    if ($conn->query($delete_query) === TRUE) {
        header("Location: list_of_students.php"); // Redirect after deletion
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Handle Update (Save Changes)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && !isset($_POST['delete_id'])) {
    $id = $_POST['id'];
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);

    $update_query = "UPDATE users SET 
        first_name = '$first_name',
        last_name = '$last_name',
        phone = '$phone',
        email = '$email'
        WHERE id = $id";

    if ($conn->query($update_query) === TRUE) {
        header("Location: list_of_students.php?updated=1"); // Redirect after update
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<link rel="stylesheet" href="assets/css/list_of_students.css">

<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body">
                    <h1 class="page-title">Student Medical Records</h1>
                    <p class="page-subtitle">Manage and track student medical documentation</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-2 mb-md-0">Student List</h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="search-input" class="form-control border-start-0"
                            placeholder="Search by Name or ID">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-records-table">
                            <thead>
                                <tr>
                                    <th data-index="0">Student ID <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="1">Student Name <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="2">Phone <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="3">Email <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="4">Status <i class="fas fa-sort sort-icon"></i></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qry = 'SELECT * FROM users';
                                $result = $conn->query($qry);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td>
                                                <div class="student-info d-flex align-items-center">
                                                    <img src="assets/img/photo.png" alt="Student" class="student-avatar me-2">
                                                    <div>
                                                        <h6 class="mb-0"><?= $row['first_name'] ?> <?= $row['last_name'] ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $row['phone'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><span class="status-badge bg-success"><?= $row['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                                            <td>
                                                <div class="actions">
                                                    <button type="button" class="btn btn-icon" title="View Record"
                                                        onclick="window.location.href='student_details.php?id=<?= $row['id'] ?>'">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-icon" title="Edit Record" data-bs-toggle="modal" data-bs-target="#editModal" onclick="setEditData(<?= $row['id'] ?>, '<?= $row['first_name'] ?>', '<?= $row['last_name'] ?>', '<?= $row['phone'] ?>', '<?= $row['email'] ?>')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-icon" title="Delete Record" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteData(<?= $row['id'] ?>)">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">Showing 1 to 10 of 50 entries</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student Record</h5>
                <?php if (isset($_GET['updated'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Student record updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

            </div>
            <form id="editForm" method="POST" action="edit_student.php">
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Student Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST" action="list_of_students.php">
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                    <input type="hidden" id="deleteId" name="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Sort/Filter/Search Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.student-records-table');
        const headers = table.querySelectorAll('thead th[data-index]');
        const icons = table.querySelectorAll('.sort-icon');

        let currentSort = {
            index: null,
            ascending: true
        };

        function sortTable(index, isNumeric = false) {
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const ascending = currentSort.index === index ? !currentSort.ascending : true;

            rows.sort((a, b) => {
                let textA = a.cells[index].textContent.trim();
                let textB = b.cells[index].textContent.trim();

                if (index === 1) { // For student name inside h6
                    textA = a.cells[index].querySelector('h6').textContent.trim();
                    textB = b.cells[index].querySelector('h6').textContent.trim();
                }

                const valA = isNumeric ? parseFloat(textA) : textA.toLowerCase();
                const valB = isNumeric ? parseFloat(textB) : textB.toLowerCase();

                return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
            });

            const tbody = table.querySelector('tbody');
            rows.forEach(row => tbody.appendChild(row));

            icons.forEach(icon => {
                icon.classList.remove('fa-arrow-up', 'fa-arrow-down');
                icon.classList.add('fa-sort');
            });

            const currentIcon = headers[index].querySelector('.sort-icon');
            currentIcon.classList.remove('fa-sort');
            currentIcon.classList.add(ascending ? 'fa-arrow-up' : 'fa-arrow-down');

            currentSort.index = index;
            currentSort.ascending = ascending;
        }

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const index = parseInt(header.getAttribute('data-index'));
                const isNumeric = header.textContent.toLowerCase().includes('id');
                sortTable(index, isNumeric);
            });
        });

        document.getElementById('search-input').addEventListener('input', function() {
            const value = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const id = row.cells[0].textContent.toLowerCase();
                const name = row.cells[1].querySelector('h6').textContent.toLowerCase();
                row.style.display = id.includes(value) || name.includes(value) ? '' : 'none';
            });
        });
    });

    function setEditData(id, firstName, lastName, phone, email) {
        document.getElementById('editId').value = id;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('editPhone').value = phone;
        document.getElementById('editEmail').value = email;
    }

    function setDeleteData(id) {
        document.getElementById('deleteId').value = id;
    }
</script>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';
?>