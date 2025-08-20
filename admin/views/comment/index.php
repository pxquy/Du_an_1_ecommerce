<?php
if (isset($_SESSION['success'])) {
    $class = $_SESSION['success'] ? 'alert-success' : 'alert-danger';
    echo "<div class='alert $class'>{$_SESSION['msg']}</div>";
    unset($_SESSION['success'], $_SESSION['msg']);
}
?>


<!-- Bộ lọc -->
<form id="commentFilter" class="d-flex align-items-end gap-2 mb-3" onsubmit="return false;">
    <div class="flex-grow-1">
        <label class="form-label">Tìm kiếm</label>
        <input type="text" name="keyword" class="form-control" placeholder="Tên khách hàng hoặc sản phẩm...">
    </div>
    <div>
        <label class="form-label">Sắp xếp đánh giá</label>
        <select name="sortRating" class="form-select">
            <option value="">--</option>
            <option value="rating_desc">Cao → Thấp</option>
            <option value="rating_asc">Thấp → Cao</option>
        </select>
    </div>
    <div>
        <label class="form-label">Sắp xếp thời gian</label>
        <select name="sortDate" class="form-select">
            <option value="">--</option>
            <option value="created_desc">Mới nhất</option>
            <option value="created_asc">Cũ nhất</option>
        </select>
    </div>
    <div>
        <button id="btnReset" type="button" class="btn btn-secondary">Reset</button>
    </div>
</form>


<!-- Danh sách bình luận -->
<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm">
        <thead class="border bg-gray-200/80 text-gray-600 text-left">
            <tr>
                <th class="p-4">STT</th>
                <th class="p-4">Nội dung</th>
                <th class="p-4">Đánh giá</th>
                <th class="p-4">Trạng thái</th>
                <th class="p-4">Hành động</th>
            </tr>
        </thead>

        <tbody id="commentList"></tbody>
    </table>
</div>

<!-- Phân trang -->
<div id="pagination" class="mt-3 d-flex gap-2"></div>

<script>
    const BASE = '<?= BASE_URL_ADMIN ?>';
    let state = { page: 1, perPage: 10 };

    function buildParams() {
        const f = document.getElementById('commentFilter');
        const p = new URLSearchParams();
        p.set('ajax', '1');
        p.set('page', state.page);
        p.set('perPage', state.perPage);

        const keyword = f.elements['keyword'].value.trim();
        const sortRating = f.elements['sortRating'].value;
        const sortDate = f.elements['sortDate'].value;

        if (keyword) p.set('q', keyword);

        // Ưu tiên sort theo rating nếu có, nếu không thì theo ngày
        if (sortRating) {
            p.set('sort', sortRating);
        } else if (sortDate) {
            p.set('sort', sortDate);
        }

        return p.toString();
    }


    async function loadComments() {
        const url = `${BASE}&action=comments-index&${buildParams()}`;
        const res = await fetch(url);
        const json = await res.json();
        renderTable(json.data || []);
        renderPager(json.meta || { page: 1, totalPage: 1 });
    }

    function renderTable(rows, level = 0) {
        const tbody = document.getElementById('commentList');
        if (level === 0) tbody.innerHTML = '';

        rows.forEach((comment, index) => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 border border-b';

            // Chỉ bình luận cha có sao
            let stars = '';
            if (!comment.parentId) {
                stars = [...Array(5)].map((_, i) => `
                <span style="color:${i < comment.rating ? 'orange' : '#ccc'}">★</span>
            `).join('');
            }

            const status = comment.isApproved ? 'Hiển thị' : 'Đã ẩn';
            const deleteBtn = comment.isApproved
                ? `<a href="${BASE}&action=comments-softDelete&id=${comment.id}" onclick="return confirm('Bạn có chắc muốn ẩn bình luận này?')" class="group w-8 h-8 flex items-center justify-center rounded hover:bg-slate-100"><i class="fas fa-trash text-red-500"></i></a>`
                : `<a href="${BASE}&action=comments-restore&id=${comment.id}" onclick="return confirm('Khôi phục bình luận này?')" class="btn btn-success btn-sm">Khôi phục</a>`;

            const replyBtn = comment.isApproved && !comment.parentId
                ? `<button class="btn btn-primary" onclick="toggleReplyForm(${comment.id})">Trả lời</button>`
                : '';

            tr.innerHTML = `
   <td class="p-4">
    ${!comment.parentId ? (state.page - 1) * state.perPage + index + 1 : ''}
</td>
    <td class="p-4">
        <div style="margin-left: ${level * 30}px">
            <p class="font-medium">${comment.content}</p>
            <p class="text-xs text-gray-500">
    ${comment.parentId ? 'Người phản hồi' : 'Khách hàng'}: ${comment.fullName}
</p>

          ${!comment.parentId ? `<p class="text-xs text-gray-500">Sản phẩm: ${comment.title}</p>` : ''}
            <div class="mt-1">${replyBtn}</div>
        </div>
    </td>
    <td class="p-4">${stars}</td>
    <td class="p-4">${status}</td>
    <td class="p-4">${deleteBtn}</td>
`;
            tbody.appendChild(tr);

            // THÊM form trả lời nếu là bình luận cha
            if (!comment.parentId) {
                const replyTr = document.createElement('tr');
                replyTr.id = `reply-form-row-${comment.id}`;
                replyTr.style.display = 'none';
                replyTr.innerHTML = `
                <td colspan="4" class="p-4">
                    <div style="margin-left: ${(level + 1) * 30}px">
                        <textarea id="reply-content-${comment.id}" class="form-control mb-2" rows="2" placeholder="Nội dung trả lời..."></textarea>
                        <button class="btn btn-sm btn-primary" onclick="submitReply(${comment.id})">Gửi trả lời</button>
                    </div>
                </td>
            `;
                tbody.appendChild(replyTr);
            }

            // Hiển thị bình luận con
            if (comment.children && comment.children.length > 0) {
                renderTable(comment.children, level + 1);
            }
        });
    }

    function toggleReplyForm(id) {
        const row = document.getElementById(`reply-form-row-${id}`);
        if (row) {
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    }


    async function submitReply(parentId) {
        const content = document.getElementById(`reply-content-${parentId}`).value.trim();
        if (!content) {
            alert('Vui lòng nhập nội dung trả lời.');
            return;
        }

        try {
            const res = await fetch(`${BASE}&action=comments-reply`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ parentId, content }),
            });

            const result = await res.json();
            if (result.success) {
                loadComments();
            } else {
                alert(result.msg || 'Lỗi gửi trả lời.');
            }
        } catch (err) {
            console.error(err);
            alert('Lỗi kết nối máy chủ.');
        }
    }

    function renderPager(meta) {
        const totalPage = meta.totalPage || 1, page = meta.page || 1;
        let html = '';
        for (let i = 1; i <= totalPage; i++) {
            html += `<button onclick="goPage(${i})" class="${i === page ? 'bg-indigo-500 text-white' : 'bg-white'} px-2 py-1 border rounded">${i}</button>`;
        }
        document.getElementById('pagination').innerHTML = html;
    }

    function goPage(i) {
        state.page = i;
        loadComments();
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadComments();

        const f = document.getElementById('commentFilter');
        f.elements['keyword'].addEventListener('input', () => { state.page = 1; loadComments(); });
        f.elements['sortRating'].addEventListener('change', () => { state.page = 1; loadComments(); });
        f.elements['sortDate'].addEventListener('change', () => { state.page = 1; loadComments(); });

        document.getElementById('btnReset')?.addEventListener('click', () => {
            f.reset();
            state.page = 1;
            loadComments();
        });
    });

</script>