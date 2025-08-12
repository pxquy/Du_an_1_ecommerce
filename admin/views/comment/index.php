<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
    unset($_SESSION['success']);
    unset($_SESSION['msg']);
}
?>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm">
        <thead class="border bg-gray-200/80 text-gray-600 text-left">
            <tr>
                <th class="p-4 text-gray-600/70">Nội dung</th>
                <th class="p-4 text-gray-600/70">Đánh giá</th>
                <th class="p-4 text-gray-600/70">Trạng thái</th>
                <th class="p-4 text-gray-600/70">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($data as $comment): ?>
                <?php if (!$comment['parentId']): // Chỉ xử lý bình luận gốc ?>
                    <!-- Bình luận cha -->
                    <tr class="hover:bg-gray-50 border border-b">
                        <td class="p-4 flex items-center gap-3">
                            <div>
                                <p class="font-medium"><?= htmlspecialchars($comment['content']) ?></p>
                                <p class="text-xs text-gray-500">Khách hàng: <?= htmlspecialchars($comment['fullName']) ?></p>
                                <p class="text-xs text-gray-500">Sản phẩm: <?= htmlspecialchars($comment['title']) ?></p>
                            </div>
                        </td>
                        <td class="p-4">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span style="color:<?= $i <= $comment['rating'] ? 'orange' : '#ccc' ?>">★</span>
                            <?php endfor; ?>
                        </td>
                        <td class="p-4"><?= $comment['isApproved'] ? 'Hiển thị' : 'Đã ẩn' ?></td>
                        <td class="p-4">
                            <?php if ($comment['isApproved'] == 1): ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=comments-softDelete&id=' . $comment['id'] ?>"
                                    onclick="return confirm('Bạn có chắc muốn ẩn bình luận này?')"
                                    class="group w-8 h-8 flex items-center justify-center rounded transition-all duration-200 text-slate-500 hover:bg-slate-100">
                                    <i class="fas fa-trash text-slate-500 group-hover:text-red-500"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL_ADMIN . '&action=comments-restore&id=' . $comment['id'] ?>"
                                    onclick="return confirm('Bạn có chắc muốn khôi phục bình luận này?')"
                                    class="btn btn-success btn-sm">Khôi phục</a>
                            <?php endif ?>
                        </td>
                    </tr>



                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>