<?php

include $this->resolve('partials/_header.php'); ?>

<section
        class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded"
>
    <form method="post" class="grid grid-cols-1 gap-6">
        <?php
        include $this->resolve("partials/_csrf.php"); ?>
        <!-- Email -->
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input
                    name="email"
                    value="<?= e($oldFormData['email'] ?? 'ahmaddeghady99@gmail.com') ?>"
                    type="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="john@example.com"
            />
            <?php
            if (!empty($errors['email'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['email'])) ?></p>
            <?php
            endif; ?>
        </label>
        <!-- Age -->
        <label class="block">
            <span class="text-gray-700">Age</span>
            <input
                    name="age"
                    value="<?= e($oldFormData['age'] ?? '25') ?>"
                    type="number"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder=""
            />
            <?php
            if (!empty($errors['age'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['age'])) ?></p>
            <?php
            endif; ?>
        </label>
        <!-- Country -->
        <label class="block">
            <span class="text-gray-700">Country</span>
            <select name="country"
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option value="USA" <?= $oldFormData['country'] === 'USA' ? 'selected' : '' ?> >USA</option>
                <option value="Canada"<?= $oldFormData['country'] === 'Canada' ? 'selected' : '' ?> >Canada</option>
                <option value="Mexico" <?= $oldFormData['country'] === 'Mexico' ? 'selected' : '' ?> >Mexico</option>
                <option value="Invalid" <?= $oldFormData['country'] === 'Invalid' ? 'selected' : '' ?> >Invalid
                    Country
                </option>
            </select>
            <?php
            if (!empty($errors['country'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['country'])) ?></p>
            <?php
            endif; ?>
        </label>
        <!-- Social Media URL -->
        <label class="block">
            <span class="text-gray-700">Social Media URL</span>
            <input
                    name="socialMediaURL"
                    value="<?= e($oldFormData['socialMediaURL'] ?? 'http://localhost:9000/register') ?>"
                    type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder=""
            />
            <?php
            if (!empty($errors['socialMediaURL'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['socialMediaURL'])) ?></p>
            <?php
            endif; ?>
        </label>
        <!-- Password -->
        <label class="block">
            <span class="text-gray-700">Password</span>
            <input
                    name="password"
                    type="password"
                    value="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder=""
            />
            <?php
            if (!empty($errors['password'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['password'])) ?></p>
            <?php
            endif; ?>
        </label>
        <!-- Confirm Password -->
        <label class="block">
            <span class="text-gray-700">Confirm Password</span>
            <input
                    name="confirmPassword"
                    type="password"
                    value="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder=""
            />
            <?php
            if (!empty($errors['confirmPassword'])): ?>
                <p class="field-error"><?= e(implode(', ', $errors['confirmPassword'])) ?></p>
            <?php
            endif; ?>
        </label>
        <!-- Terms of Service -->
        <div class="block">
            <div class="mt-2">
                <div>
                    <label class="inline-flex items-center">
                        <input
                                name="tos"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50"
                                type="checkbox"
                        />
                        <span class="ml-2">I accept the terms of service.</span>
                        <?php
                        if (!empty($errors['tos'])): ?>
                            <p class="field-error"><?= e(implode(', ', $errors['tos'])) ?></p>
                        <?php
                        endif; ?>
                    </label>
                </div>
            </div>
        </div>
        <?php
        if (!empty($errors['FormErrors'])): ?>
            <p class="field-error"><?= e(implode(', ', $errors['FormErrors'])) ?></p>
        <?php
        endif; ?>
        <button
                type="submit"
                class="block w-full py-2 bg-indigo-600 text-white rounded"
        >
            Submit
        </button>
    </form>
</section>

<?php
include $this->resolve('partials/_footer.php'); ?>
