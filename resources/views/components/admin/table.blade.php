@props(['headers' => []])

<div class="hidden md:block overflow-x-auto rounded-lg border border-gray-300 bg-white">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-100">
            <tr>
                @foreach ($headers as $header)
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
