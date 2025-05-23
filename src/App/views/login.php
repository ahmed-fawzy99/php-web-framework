<?php

include $this->resolve("partials/_header.php"); ?>

    <section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
        <form method="POST" class="grid grid-cols-1 gap-6">
            <?php
            include $this->resolve("partials/_csrf.php"); ?>
            <label class="block">
                <span class="text-gray-700">Email address</span>
                <input name="email" type="email"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       value="<?= e($oldFormData['email'] ?? '') ?>"
                       placeholder="john@example.com"/>
                <?php
                if (!empty($errors['email'])): ?>
                    <p class="field-error"><?= e(implode(', ', $errors['email'])) ?></p>
                <?php
                endif; ?>
            </label>
            <label class="block">
                <span class="text-gray-700">Password</span>
                <input name="password" type="password"
                       required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder=""/>
            </label>
            <?php
            if (!empty($errors['password'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['password'])) ?></p>
            <?php
            endif; ?>

            <?php
            if (!empty($errors['FormErrors'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['FormErrors'])) ?></p>
            <?php
            endif; ?>
            <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
                Submit
            </button>
        </form>
    </section>

<?php
include $this->resolve("partials/_footer.php"); ?>