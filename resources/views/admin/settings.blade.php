<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">System Settings</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6">
                <!-- General Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="#" id="generalSettingsForm">
                            @csrf
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="HR Management System">
                            </div>
                            <div class="mb-3">
                                <label for="company_email" class="form-label">Company Email</label>
                                <input type="email" class="form-control" id="company_email" name="company_email" value="info@hrms.com">
                            </div>
                            <div class="mb-3">
                                <label for="company_phone" class="form-label">Company Phone</label>
                                <input type="text" class="form-control" id="company_phone" name="company_phone" value="+1 (555) 123-4567">
                            </div>
                            <div class="mb-3">
                                <label for="company_address" class="form-label">Company Address</label>
                                <textarea class="form-control" id="company_address" name="company_address" rows="3">123 Business Street, Suite 100, New York, NY 10001</textarea>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Email Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Email Settings</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="#" id="emailSettingsForm">
                            @csrf
                            <div class="mb-3">
                                <label for="mail_driver" class="form-label">Mail Driver</label>
                                <select class="form-select" id="mail_driver" name="mail_driver">
                                    <option value="smtp" selected>SMTP</option>
                                    <option value="sendmail">Sendmail</option>
                                    <option value="mailgun">Mailgun</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mail_host" class="form-label">Mail Host</label>
                                <input type="text" class="form-control" id="mail_host" name="mail_host" value="smtp.mailtrap.io">
                            </div>
                            <div class="mb-3">
                                <label for="mail_port" class="form-label">Mail Port</label>
                                <input type="text" class="form-control" id="mail_port" name="mail_port" value="2525">
                            </div>
                            <div class="mb-3">
                                <label for="mail_username" class="form-label">Mail Username</label>
                                <input type="text" class="form-control" id="mail_username" name="mail_username" value="username">
                            </div>
                            <div class="mb-3">
                                <label for="mail_password" class="form-label">Mail Password</label>
                                <input type="password" class="form-control" id="mail_password" name="mail_password" value="password">
                            </div>
                            <div class="mb-3">
                                <label for="mail_encryption" class="form-label">Mail Encryption</label>
                                <select class="form-select" id="mail_encryption" name="mail_encryption">
                                    <option value="tls" selected>TLS</option>
                                    <option value="ssl">SSL</option>
                                    <option value="none">None</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <!-- System Preferences -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">System Preferences</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="#" id="systemPreferencesForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Default Language</label>
                                <select class="form-select" name="default_language">
                                    <option value="en" selected>English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Default Timezone</label>
                                <select class="form-select" name="default_timezone">
                                    <option value="UTC" selected>UTC</option>
                                    <option value="America/New_York">Eastern Time (US & Canada)</option>
                                    <option value="America/Chicago">Central Time (US & Canada)</option>
                                    <option value="America/Denver">Mountain Time (US & Canada)</option>
                                    <option value="America/Los_Angeles">Pacific Time (US & Canada)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Format</label>
                                <select class="form-select" name="date_format">
                                    <option value="Y-m-d" selected>YYYY-MM-DD</option>
                                    <option value="m/d/Y">MM/DD/YYYY</option>
                                    <option value="d/m/Y">DD/MM/YYYY</option>
                                    <option value="M d, Y">Month DD, YYYY</option>
                                </select>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="enable_notifications" name="enable_notifications" checked>
                                <label class="form-check-label" for="enable_notifications">Enable Email Notifications</label>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Backup & Maintenance -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Backup & Maintenance</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5>Database Backup</h5>
                            <p>Create a backup of your database to prevent data loss.</p>
                            <button class="btn btn-primary">Generate Backup</button>
                        </div>
                        <hr>
                        <div class="mb-4">
                            <h5>Clear Cache</h5>
                            <p>Clear the application cache to resolve potential issues.</p>
                            <button class="btn btn-warning">Clear Cache</button>
                        </div>
                        <hr>
                        <div>
                            <h5>System Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>PHP Version</th>
                                        <td>{{ phpversion() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Laravel Version</th>
                                        <td>{{ app()->version() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Server</th>
                                        <td>{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Prevent forms from submitting (for demo purposes)
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success alert-dismissible fade show';
                    alert.innerHTML = `
                        Settings saved successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    form.parentNode.insertBefore(alert, form);
                    
                    // Auto dismiss after 3 seconds
                    setTimeout(() => {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }, 3000);
                });
            });
        });
    </script>
</x-admin-layout>
