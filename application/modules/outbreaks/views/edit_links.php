
    <div class="container mt-5">
        <h5 class="mb-4">Edit Menu Links for Outbreak</h5>

        <!-- Outbreak Selection -->
        <div class="form-group">
            <label for="outbreakSelect">Select Outbreak</label>
            <select class="form-control" id="outbreakSelect" name="outbreak_id">
                <option value="" disabled selected>Select an outbreak</option>
                <?php foreach ($outbreaks as $outbreak): ?>
                    <option value="<?= $outbreak->id; ?>">
                        <?= $outbreak->outbreak_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Table to edit menu items -->
        <form id="editMenuLinksForm">
            <table class="table table-bordered" id="menuItemsTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Tab</th>
                        <th>URL</th>
                        <th>Icon</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Menu items will be dynamically populated here -->
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary mb-3" id="addRow">Add Menu Item</button>
            <button type="submit" class="btn btn-primary mb-3">Save Changes</button>
        </form>

        <!-- Copy menu items from another outbreak -->
        <div class="mt-5">
            <h3>Copy Menu Items from Another Outbreak</h3>
            <div class="form-group">
                <label for="copyOutbreakSelect">Select Outbreak to Copy From</label>
                <select class="form-control" id="copyOutbreakSelect" name="copy_outbreak_id">
                    <option value="" disabled selected>Select an outbreak</option>
                    <?php foreach ($outbreaks as $outbreak): ?>
                        <option value="<?= $outbreak->id; ?>">
                            <?= $outbreak->outbreak_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-info" id="copyMenuItems">Copy Menu Items</button>
        </div>
    </div>
