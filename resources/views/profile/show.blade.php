<x-layouts.app :title="__('User詳細')">
    <div class="p-6">
        <h2 class="font-semibold text-xl mb-4">
            {{ __('User詳細') }}
        </h2>

        <a href="{{ route('tweets.index') }}"
           class="text-blue-500 hover:text-blue-700 mr-2">
            一覧に戻る
        </a>

        {{-- ユーザー情報 --}}
        <div class="mt-4">
            <p class="text-lg font-semibold">
                {{ $user->name }}
            </p>

            <div class="text-sm text-gray-500 mt-2">
                <p>
                    アカウント作成日時:
                    {{ $user->created_at->format('Y-m-d H:i') }}
                </p>
            </div>

            {{-- フォロー・フォロワー数 --}}
            <div class="flex gap-4 mt-3 text-sm">
                <p>
                    フォロー:
                    {{ $user->follows->count() }}
                </p>

                <p>
                    フォロワー:
                    {{ $user->followers->count() }}
                </p>
            </div>

            {{-- フォロー・フォロー解除 --}}
            @if ($user->id !== auth()->id())
                <div class="mt-3">
                    @if ($user->followers->contains(auth()->id()))
                        <form action="{{ route('follow.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-500 hover:text-red-700">
                                unFollow
                            </button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', $user) }}" method="POST">
                            @csrf

                            <button type="submit"
                                    class="text-blue-500 hover:text-blue-700">
                                follow
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        {{-- ツイート一覧 --}}
        <div class="mt-6">
            <h3 class="font-semibold text-lg mb-4">
                Tweets
            </h3>

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

                    {{-- いいね --}}
                    @if ($tweet->liked->contains(auth()->id()))
                        <form action="{{ route('tweets.dislike', $tweet) }}"
                              method="POST"
                              class="inline-block mt-2">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-500 hover:text-red-700">
                                ♥ いいね解除
                            </button>
                        </form>
                    @else
                        <form action="{{ route('tweets.like', $tweet) }}"
                              method="POST"
                              class="inline-block mt-2">
                            @csrf

                            <button type="submit"
                                    class="text-blue-500 hover:text-blue-700">
                                ♡ いいね
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">
                    No tweets found.
                </p>
            @endforelse

            {{-- ページネーション --}}
            <div class="mt-4">
                {{ $tweets->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
