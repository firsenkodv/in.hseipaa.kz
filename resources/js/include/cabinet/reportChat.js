import {axiosLaravel} from '../axios/axiosLaravel.js';

export function reportChatInit() {
    document.querySelectorAll('.report-chat__send-btn').forEach(btn => {
        if (btn.dataset.chatBound) return;
        btn.dataset.chatBound = '1';
        btn.addEventListener('click', sendReportMessage);
    });

    scrollReportChat();
}

function scrollReportChat() {
    document.querySelectorAll('.report-chat__messages').forEach(el => {
        el.scrollTop = el.scrollHeight;
    });
}

async function sendReportMessage(e) {
    const container = e.target.closest('.report-chat');
    if (!container) return;

    const textarea = container.querySelector('.report-chat__textarea');
    const body = textarea.value.trim();
    if (!body) return;

    const reportId = container.dataset.reportId;
    const userId   = container.dataset.userId || null;
    const url      = container.dataset.sendUrl;

    const btn = e.target;
    btn.disabled = true;

    try {
        const payload = { report_id: parseInt(reportId), body };
        if (userId) payload.user_id = parseInt(userId);

        const result = await axiosLaravel(payload, url);

        if (result && result.success && result.html) {
            const messages = container.querySelector('.report-chat__messages');
            const empty = messages.querySelector('.report-chat__empty');
            if (empty) empty.remove();
            messages.insertAdjacentHTML('beforeend', result.html);
            textarea.value = '';
            messages.scrollTop = messages.scrollHeight;
        }
    } catch (err) {
        console.error('Report chat error:', err);
    } finally {
        btn.disabled = false;
    }
}
