---
marp: true
theme: default

size: 16:9

style: |
    section.title {
        --title-height: 100px;
        --subtitle-height: 70px;

        overflow: visible;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: 1fr var(--title-height) var(--subtitle-height) 1fr;
        grid-template-areas: "." "title" "subtitle" ".";
    }

    section.title h1,
    section.title h2 {
        margin: 0;
        padding: 0;
        text-align: center;
        height: var(--area-height);
        line-height: var(--area-height);
        font-size: calc(var(--area-height) * 0.7);

    }

    section.title h1 {
        grid-area: title;
        --area-height: var(--title-height);
    }

    section.title h2 {
        grid-area: subtitle;
        --area-height: var(--subtitle-height);
    }

    section {
        justify-content: start;
    }
---

<!-- _class: title -->

# レオレアーキテクチャ

---
# 前置き
- このアーキテクチャが全てじゃないしもっといいものもあると思う
- あくまで今これが個人的に一番しっくりきてる
    - 1か月後には別のこと言ってるかもしれないｗ

---

## Laravel のデフォルトのアーキテクチャと役割

|            | 役割                                                  |
| ---------- | :---------------------------------------------------- |
| controller | リクエストを受け取り model と view とのやり取りを行う |
| model      | ビジネスロジック、SQL 構築、データアクセス            |
| view       | 表示                                                  |

---

## オレオレアーキテクチャの場合

|                | 役割                                                                |
| -------------- | :------------------------------------------------------------------ |
| controller     | リクエストを受け取り **usecase に依頼し、レスポンスの形式を決める** |
| model          | ビジネスロジック、~~SQL 構築~~、データアクセス                      |
| view           | 表示                                                                |
| **usecase**    | **そのリクエストで何を表現するか**                                  |
| **service**    | **repositoryでSQLを構築するためのデータの作成** <br> **システムがゆえに発生する処理**                                |
| **repository** | **データアクセスの為に SQL 構築**                                   |

---

## usecase
- 受け取ったリクエストを使ってリクエストで何をしたいかを表現する
```php
    public function __invoke(int $user_id, array $attributes): Book
    {
        // 本の登録
        $book = $this->book_service->create($attributes);
        // フォロワーを取得
        $follow_users = $this->follow_user_service->getFollowerUsers($user_id)->pluck('followerUser');
        // 取得したフォロワーに新しい本が追加されたことを通知
        Notification::send($follow_users, new ReleaseNotification($book));
        // 登録した本を返す
        return $book;
    }
```

---
## service 1
- repositoryでSQLを作成するためのデータ構築
```php
    public function findByUserId(int $user_id): Collection
    {
        // SQLのwhere句で使う条件の作成
        $conditions = ['user_id' => $user_id];
        if (何か) {
            $conditions['hoge'] = 'piyo';
        }
        $books = $this->repository->findWithConditions(
            conditions: $conditions, 
            // 一緒に取得するリレーション先の配列作成
            relations: ['reviews']
        );
        処理...
    }
```
---
## service 2
- システムがゆえに発生する処理
  - 各モデルに対する処理(ループ処理)
```php
    public function findByUserId(int $user_id): Collection
    {
        // Bookのレビュー平均値はDBに保持していないのでここでループしてデータとして追加
        return $books->map(function (\Illuminate\Database\Eloquent\Model $book) {
            return [
                ...$book->only(['id', 'user_id', 'title', 'content',]),
                'avg_score' => $book->getAvgScore(),
            ];
        });
    }
```

