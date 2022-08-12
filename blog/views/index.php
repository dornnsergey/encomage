<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous" defer></script>
    <script src="js/app.js" defer></script>
    <title>Posts</title>
</head>
<body>
<div id="app">
    <header>
        <div class="container">
            <div class="fw-bold fs-2 text-center my-3">Counter</div>

            <div class="row justify-content-between mb-5">
                <div class="col-2 text-bg-success text-center p-3">
                    <div><?= $negativeCount ?></div>
                    <div>Negative Posts</div>
                </div>
                <div class="col-2 text-bg-success text-center p-3">
                    <div><?= count($posts) ?></div>
                    <div>All Posts</div>
                </div>
                <div class="col-2 text-bg-success text-center p-3">
                    <div><?= $positiveCount ?></div>
                    <div>Positive Posts</div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="fw-bold fs-2 text-center">Posts</div>

            <div class="row row-cols-5 justify-content-end mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postModal">
                    Add Post
                </button>

                <!-- Modal -->
                <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="postForm">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" type="text" name="name" required>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Text</label>
                                        <textarea class="form-control" name="text" rows="8" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Add Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--    EndModal-->
            </div>


            <?php
            foreach ($posts as $post): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fst-italic">by <?= htmlspecialchars($post->name) ?></span>

                            <button class="btn btn-primary col-2" data-bs-toggle="modal"
                                    data-bs-target="#post<?= $post->id ?>commentModal">
                                Add Comment
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="post<?= $post->id ?>commentModal" tabindex="-1"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="/comments?post=<?= $post->id ?>" method="POST" data-comment-form>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input class="form-control" type="text" name="name" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Text</label>
                                                    <textarea class="form-control" name="text" rows="8"
                                                              required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Add Comment
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--                        EndModal  -->
                        </div>
                    </div>

                    <div class="card-body col-10">
                        <?= htmlspecialchars($post->text) ?>
                    </div>

                    <div class="class-footer d-flex justify-content-between py-4 px-4">
                        <div>
                            <?php foreach (range(1, 5) as $value): ?>
                                <form class="d-inline-block <?php if ($post->rating >= $value) echo 'bg-warning' ?>"
                                      action="/posts/rate" method="POST">
                                    <input type="hidden" name="id" value="<?= $post->id ?>">
                                    <input type="hidden" name="rating" value="<?= $value ?>">
                                    <i class="bi bi-star" onclick="this.parentElement.submit()"></i>
                                </form>
                            <?php endforeach ?>
                        </div>
                        <div><?= date('d-m-Y', strtotime($post->created_at)) ?></div>
                    </div>

                    <?php
                    foreach ($post->comments as $comment): ?>
                        <div class="col-11 offset-1 mb-3">
                            <div class="card me-2">
                                <div class="card-header pt-4">
                                    <span>by <?= htmlspecialchars($comment->name) ?></span>
                                </div>

                                <div class="card-body col-10">
                                    <?= htmlspecialchars($comment->text) ?>
                                </div>

                                <div class="class-footer py-4 px-4">
                                    <div class="float-end"><?= date('d-m-Y', strtotime($post->created_at)) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach ?>
                </div>
            <?php
            endforeach ?>
        </div>
    </main>
</div>

    <div class="alert alert-dismissible fade position-fixed end-0 bottom-0 mb-4 me-2" role="alert"
         id="flash">
        <span></span>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-danger alert-dismissible show position-fixed end-0 bottom-0 mb-4 me-2" role="alert"
             id="error">
            <strong>Error!</strong> <?= $_SESSION['flash'] ?>
        </div>
    <?php endif ?>
    <?php unset($_SESSION['flash']) ?>
</body>
</html>