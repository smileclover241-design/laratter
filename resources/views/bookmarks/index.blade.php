<x-layouts.app :title="__('保存したツイート')">
    <div class="p-6">
        <h2 class="font-semibold text-xl mb-4">
            🔖 保存したツイート
        </h2>

        <a href="{{ route('tweets.index') }}"
           class="text-blue-500 hover:text-blue-700">
            ← ツイート一覧に戻る
        </a>

        <div class="mt-6">
            @forelse ($tweets as $tweet)
                <div class="border-b py-4">
                    <div class="mb-2">
                        <a href="{{ route('profile.show', $tweet->user) }}"
                           class="font-semibold text-blue-500 hover:text-blue-700">
                            {{ $tweet->user->name }}
                        </a>
                    </div>

                    <p class="text-gray-800">
                        {{ $tweet->tweet }}
                    </p>

                    <div class="text-sm text-gray-500 mt-2">
                        {{ $tweet->created_at->format('Y-m-d H:i') }}
                    </div>

                    <form action="{{ route('tweets.unbookmark', $tweet) }}"
                          method="POST"
                          class="mt-2">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-red-500 hover:text-red-700">
                            🔖 保存解除
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500">
                    保存したツイートはありません。
                </p>
            @endforelse

            <div class="mt-4">
                {{ $tweets->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>