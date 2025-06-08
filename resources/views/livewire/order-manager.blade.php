<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Создать заказ</h2>

    <form wire:submit.prevent="save" class="space-y-4 mb-8">
        <div>
            <label class="block mb-1 font-medium text-gray-700">Товар:</label>
            <select wire:model="product_id" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
                <option value="">Выберите товар</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}">{{ $prod->name }} ({{ $prod->category->name ?? '-' }})</option>
                @endforeach
            </select>
            @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Количество:</label>
            <input type="number" min="1" wire:model="quantity" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
            @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">ФИО покупателя:</label>
            <input type="text" wire:model="customer_fullname" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
            @error('customer_fullname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Комментарий:</label>
            <textarea wire:model="comment" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400"></textarea>
        </div>
        <div>
            <label class="block mb-1 font-medium text-gray-700">Дата создания:</label>
            <input type="date" wire:model="created_at" class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400">
            @error('created_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="flex space-x-4 mt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded transition" type="submit">
                {{ $isEditMode ? 'Сохранить' : 'Добавить' }}
            </button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded transition" wire:click="resetForm">Сбросить</button>
        </div>
    </form>

    <h3 class="text-xl font-semibold mb-3 text-gray-700">Список заказов</h3>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase">
            <tr>
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">Дата</th>
                <th class="py-2 px-4">ФИО покупателя</th>
                <th class="py-2 px-4">Товар</th>
                <th class="py-2 px-4">Количество</th>
                <th class="py-2 px-4">Комментарий</th>
                <th class="py-2 px-4">Статус</th>
                <th class="py-2 px-4">Итоговая цена (руб.)</th>
                <th class="py-2 px-4">Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-2 px-4">{{ $order->order_number }}</td>
                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y') }}</td>
                    <td class="py-2 px-4">{{ $order->customer_fullname }}</td>
                    <td class="py-2 px-4">{{ $order->product->name ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $order->quantity }}</td>
                    <td class="py-2 px-4">{{ $order->comment }}</td>
                    <td class="py-2 px-4">
                        {{ $order->status === 'done' ? 'Выполнен' : 'Новый' }}
                        @if($order->status === 'new')
                            <form method="POST" wire:submit.prevent="markDone({{ $order->order_number }})" class="inline">
                                <button type="submit" class="ml-2 text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">Выполнить</button>
                            </form>
                        @endif
                    </td>
                    <td class="py-2 px-4">
                        {{ number_format(($order->product->price ?? 0) * $order->quantity / 100, 2, ',', ' ') }}
                    </td>
                    <td class="py-2 px-4">
                        <button wire:click="edit({{ $order->order_number }})" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded transition mr-2">Редактировать</button>
                        <button wire:click="delete({{ $order->order_number }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">Удалить</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="py-4 px-4 text-center text-gray-400">Пока нет заказов</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
