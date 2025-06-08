<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Товары</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-8">
        <div>
            <label class="block mb-1 font-medium text-gray-700">Название:</label>
            <input class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400" type="text" wire:model="name">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Категория:</label>
            <select wire:model="category_id" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
                <option value="">Выберите категорию</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Описание:</label>
            <textarea wire:model="description" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400"></textarea>
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Цена:</label>
            <input class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400" type="number" wire:model="price">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex space-x-4 mt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded transition" type="submit">
                {{ $isEditMode ? 'Сохранить' : 'Добавить' }}
            </button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded transition" wire:click="resetForm">Сбросить</button>
        </div>
    </form>

    <h3 class="text-xl font-semibold mb-3 text-gray-700">Список товаров</h3>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase">
            <tr>
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">Название</th>
                <th class="py-2 px-4">Категория</th>
                <th class="py-2 px-4">Описание</th>
                <th class="py-2 px-4">Цена (руб.)</th>
                <th class="py-2 px-4">Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $prod)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-2 px-4">{{ $prod->id }}</td>
                    <td class="py-2 px-4">{{ $prod->name}}</td>
                    <td class="py-2 px-4">{{ $prod->category->name ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $prod->description }}</td>
                    <td class="py-2 px-4">{{ number_format($prod->price, 2, ',', ' ') }}</td>
                    <td class="py-2 px-4">
                        <button wire:click="edit({{ $prod->id }})" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded transition mr-2">Редактировать</button>
                        <button wire:click="delete({{ $prod->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">
                            Удалить
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-400">Пока нет товаров</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
