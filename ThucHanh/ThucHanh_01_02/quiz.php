<?php
// Tên file chứa câu hỏi
$file_path = 'quiz.txt';
$quiz_content_js_safe = '';
$error_message = '';

// Kiểm tra và đọc file
if (file_exists($file_path)) {
    $quiz_content_raw = file_get_contents($file_path);
    
    // Chuẩn bị nội dung để đưa vào chuỗi JavaScript (thoát dấu nháy đơn và xuống dòng)
    $quiz_content_js_safe = str_replace(
        ["\r\n", "\r", "\n", "'"],
        ["\\n", "\\n", "\\n", "\\'"],
        $quiz_content_raw
    );
} else {
    // Ghi lại thông báo lỗi nếu không tìm thấy file
    $error_message = 'Lỗi: File quiz.txt không tồn tại trong cùng thư mục. Vui lòng kiểm tra đường dẫn.';
    $quiz_content_js_safe = "Lỗi đọc file. Vui lòng xem console.";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Thi Trắc Nghiệm PHP</title>
    <!-- Tải Tailwind CSS để tạo giao diện đẹp và responsive -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sử dụng Font Inter */
        body { font-family: 'Inter', sans-serif; }
        .quiz-option:hover {
            background-color: #f3f4f6;
        }
        .correct-answer {
            background-color: #d1fae5; /* Màu xanh lá nhạt */
            border-color: #34d399;
        }
        .incorrect-answer {
            background-color: #fee2e2; /* Màu đỏ nhạt */
            border-color: #f87171;
        }
        /* Ẩn nút radio/checkbox mặc định */
        .quiz-option input[type="radio"],
        .quiz-option input[type="checkbox"] {
            display: none;
        }
        /* Tạo hiệu ứng khi radio/checkbox được chọn */
        .quiz-option input[type="radio"]:checked + .option-text,
        .quiz-option input[type="checkbox"]:checked + .option-text {
            background-color: #bfdbfe; /* Màu xanh dương nhạt */
            border-color: #60a5fa;
            border-width: 2px; /* Dày hơn khi chọn */
        }
        .option-text {
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 8px;
            display: block;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .option-text:hover {
             border-color: #60a5fa;
        }

        /* Thêm dấu check tùy chỉnh cho Checkbox (Câu hỏi nhiều đáp án) */
        .quiz-option input[type="checkbox"]:checked + .option-text:after {
            content: '✓';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #10b981; /* Màu xanh lục */
            font-size: 1.25rem;
            font-weight: bold;
        }
        /* Fix CSS for multi-select correct/incorrect highlight */
        .quiz-option input[type="checkbox"]:checked + .correct-answer:after,
        .quiz-option input[type="checkbox"]:checked + .incorrect-answer:after {
            content: ''; /* Ẩn dấu check tùy chỉnh khi đã chấm điểm */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div id="quiz-container" class="bg-white p-8 md:p-12 rounded-xl shadow-2xl w-full max-w-2xl">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Bài Thi Trắc Nghiệm PHP</h1>
        
        <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Lỗi!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <!-- Khu vực hiển thị đồng hồ đếm ngược -->
        <div class="flex justify-end mb-6">
            <div id="timer" class="text-2xl font-bold text-red-600 bg-red-100 p-2 rounded-lg shadow-inner transition duration-300">
                60:00
            </div>
        </div>

        <div id="quiz-form">
            <!-- Câu hỏi sẽ được chèn vào đây bởi JavaScript -->
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <!-- Nút này bây giờ sẽ mở hộp thoại xác nhận -->
            <button id="submit-btn" class="bg-indigo-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300">
                Nộp Bài
            </button>
        </div>

        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50" onclick="hideConfirmModal()">
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl max-w-sm w-full transition-all duration-300 transform scale-95" onclick="event.stopPropagation()">
                <h2 class="text-xl font-bold text-red-600 mb-4">Xác nhận Nộp bài</h2>
                <p class="text-gray-700 mb-6">Bạn có chắc chắn nộp bài không? Hãy kiểm tra lại trước khi nộp.</p>
                <div class="flex justify-between space-x-4">
                    <button onclick="hideConfirmModal()" class="flex-1 bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-400 transition duration-300">
                        Kiểm tra lại
                    </button>
                    <button id="confirm-submit-btn" class="flex-1 bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition duration-300">
                        Nộp bài
                    </button>
                </div>
            </div>
        </div>

        <!-- Result Modal (existing) -->
        <div id="result-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50" onclick="hideModal()">
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl max-w-sm w-full transition-all duration-300 transform scale-95" onclick="event.stopPropagation()">
                <h2 class="text-2xl font-bold text-indigo-700 mb-4">Kết Quả Bài Thi</h2>
                <p id="score-display" class="text-xl font-medium text-gray-800 mb-4"></p>
                <!-- Đã thêm max-h-64 và overflow-y-auto để kích hoạt thanh cuộn khi nội dung dài -->
                <div id="answers-summary" class="text-sm text-gray-600 mb-6 max-h-64 overflow-y-auto pr-2"></div>
                <button onclick="window.location.reload()" class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    Làm Lại
                </button>
            </div>
        </div>
        
    </div>

    <script>
        // Nội dung của quiz.txt được đọc bởi PHP và nhúng vào biến này
        const quizTxtContent = '<?php echo $quiz_content_js_safe; ?>';
        
        let questions = [];
        let isSubmitted = false;
        
        // --- CÁC BIẾN CHO ĐỒNG HỒ ĐẾM NGƯỢC ---
        const TOTAL_TIME_SECONDS = 60 * 60; // 60 phút
        let timeLeft = TOTAL_TIME_SECONDS;
        let timerInterval = null;
        
        /**
         * Chuyển đổi tổng số giây thành định dạng MM:SS
         * @param {number} totalSeconds - Tổng số giây còn lại.
         * @returns {string} Thời gian ở định dạng "MM:SS".
         */
        function formatTime(totalSeconds) {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            
            const formattedMinutes = String(minutes).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');
            
            return `${formattedMinutes}:${formattedSeconds}`;
        }

        /**
         * Cập nhật hiển thị đồng hồ đếm ngược trên giao diện
         */
        function updateTimerDisplay() {
            const timerElement = document.getElementById('timer');
            if (timerElement) {
                timerElement.textContent = formatTime(timeLeft);
                
                // Cảnh báo khi còn dưới 5 phút (300 giây)
                if (timeLeft <= 300) {
                    timerElement.classList.add('animate-pulse', 'text-yellow-700', 'bg-yellow-100');
                    timerElement.classList.remove('text-red-600', 'bg-red-100');
                } else {
                    timerElement.classList.remove('animate-pulse', 'text-yellow-700', 'bg-yellow-100');
                    timerElement.classList.add('text-red-600', 'bg-red-100');
                }
            }
        }

        /**
         * Bắt đầu đồng hồ đếm ngược
         */
        function startTimer() {
            updateTimerDisplay(); // Hiển thị thời gian ban đầu ngay lập tức
            
            timerInterval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timeLeft = 0;
                    updateTimerDisplay();
                    // Tự động nộp bài khi hết giờ
                    submitQuiz(true); 
                    return;
                }
                
                timeLeft--;
                updateTimerDisplay();
            }, 1000);
        }

        /**
         * Phân tích cú pháp chuỗi quizTxtContent để tạo mảng câu hỏi
         * Chú ý: Đáp án đúng bây giờ có thể là mảng (ví dụ: ['C', 'D']) nếu có dấu phẩy.
         */
        function parseQuizData(text) {
            if (text.startsWith('Lỗi: File quiz.txt')) {
                 console.error(text);
                 return [];
            }

            text = text.replace(/\\n/g, '\n');

            const questionBlocks = text.trim().split(/\n\s*\n/);
            const quiz = [];

            questionBlocks.forEach(block => {
                const lines = block.trim().split('\n');
                if (lines.length < 3) return;

                const questionText = lines[0].trim();
                const options = {};
                let rawAnswer = '';

                for (let i = 1; i < lines.length; i++) {
                    const line = lines[i].trim();
                    if (!line) continue;
                    
                    if (line.startsWith('ANSWER:')) {
                        rawAnswer = line.split(':')[1].trim();
                    } else if (/^[A-Z]\./.test(line)) {
                        const optionKey = line[0];
                        options[optionKey] = line.substring(2).trim();
                    }
                }
                
                if (Object.keys(options).length > 0 && rawAnswer) {
                    // Xử lý đáp án: tách bằng dấu phẩy và loại bỏ khoảng trắng
                    const answers = rawAnswer.split(',').map(a => a.trim()).filter(a => a.length > 0);
                    
                    quiz.push({
                        question: questionText,
                        options: options,
                        correctAnswer: answers, // Lưu đáp án dưới dạng mảng
                        isMultiChoice: answers.length > 1 // Đánh dấu là đa lựa chọn
                    });
                }
            });

            return quiz;
        }

        /**
         * Hiển thị danh sách câu hỏi ra giao diện
         */
        function renderQuiz() {
            const formContainer = document.getElementById('quiz-form');
            formContainer.innerHTML = '';

            questions.forEach((q, index) => {
                const qNum = index + 1;
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question-block mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200';
                questionDiv.id = `q-${qNum}`;
                
                // Xác định loại input: checkbox (đa lựa chọn) hay radio (đơn lựa chọn)
                const inputType = q.isMultiChoice ? 'checkbox' : 'radio';
                const typeText = q.isMultiChoice ? '(Nhiều đáp án)' : '(1 đáp án)';

                // Tiêu đề câu hỏi
                questionDiv.innerHTML = `<p class="text-lg font-semibold mb-4 text-gray-900">Câu ${qNum}: ${q.question} <span class="text-sm font-normal text-indigo-500">${typeText}</span></p>`;

                const optionsDiv = document.createElement('div');
                optionsDiv.className = 'space-y-3';

                // Lặp qua các tùy chọn (A, B, C, ...)
                Object.keys(q.options).forEach(key => {
                    const optionId = `q${qNum}o${key}`;
                    const optionText = q.options[key];
                    
                    const optionLabel = document.createElement('label');
                    optionLabel.className = 'quiz-option block cursor-pointer';
                    optionLabel.setAttribute('for', optionId);

                    optionLabel.innerHTML = `
                        <input type="${inputType}" id="${optionId}" name="q${qNum}" value="${key}" data-index="${index}" data-type="${inputType}" class="hidden">
                        <span class="option-text flex items-center space-x-3 text-gray-700">
                            <span class="font-bold w-6 text-center">${key}.</span>
                            <span>${optionText}</span>
                        </span>
                    `;
                    
                    optionsDiv.appendChild(optionLabel);
                });

                questionDiv.appendChild(optionsDiv);
                formContainer.appendChild(questionDiv);
            });
        }

        /**
         * Hiển thị modal xác nhận nộp bài
         */
        function showConfirmModal() {
            if (isSubmitted) return;
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        /**
         * Ẩn modal xác nhận nộp bài
         */
        function hideConfirmModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
        }


        /**
         * Xử lý nộp bài, chấm điểm và hiển thị kết quả
         * @param {boolean} [isTimeUp=false] - Cờ báo hiệu việc nộp bài là do hết giờ.
         */
        function submitQuiz(isTimeUp = false) {
            if (isSubmitted) return;
            isSubmitted = true;
            
            // Dừng đồng hồ đếm ngược
            if (timerInterval) {
                clearInterval(timerInterval);
            }

            // Vô hiệu hóa nút nộp bài
            document.getElementById('submit-btn').disabled = true;
            hideConfirmModal();

            let score = 0;
            const summaryDiv = document.getElementById('answers-summary');
            summaryDiv.innerHTML = '';
            
            questions.forEach((q, index) => {
                const qNum = index + 1;
                const allInputs = document.querySelectorAll(`input[name="q${qNum}"]`);
                const correctAnswers = q.correctAnswer; // Mảng đáp án đúng
                const userSelectedKeys = [];
                
                // 1. Thu thập các đáp án người dùng đã chọn
                allInputs.forEach(input => {
                    if (input.checked) {
                        userSelectedKeys.push(input.value);
                    }
                    // Vô hiệu hóa input sau khi nộp
                    input.disabled = true;
                });

                // Chuyển mảng đáp án thành chuỗi có dấu phẩy để hiển thị tóm tắt
                const userSelectedStr = userSelectedKeys.length > 0 ? userSelectedKeys.sort().join(', ') : 'Chưa chọn';
                const correctAnswersStr = correctAnswers.sort().join(', ');

                // 2. Logic chấm điểm: Phải khớp hoàn toàn cả về đáp án và số lượng
                const isCorrect = 
                    userSelectedKeys.length === correctAnswers.length &&
                    userSelectedKeys.every(key => correctAnswers.includes(key));

                if (isCorrect) {
                    score++;
                }

                // 3. Đánh dấu trên giao diện
                allInputs.forEach(input => {
                    const optionElement = input.nextElementSibling;
                    const isCorrectOption = correctAnswers.includes(input.value);

                    // A. Đánh dấu các đáp án đúng
                    if (isCorrectOption) {
                        optionElement.classList.remove('border-gray-200');
                        // Nếu câu trả lời chung là đúng, dùng màu xanh đậm (đã chọn và đúng)
                        if (input.checked && isCorrect) {
                           optionElement.classList.add('correct-answer', 'border-green-600', 'border-4'); 
                        } else if (!input.checked) {
                            // Đáp án đúng nhưng chưa được chọn
                            optionElement.classList.add('correct-answer', 'border-4');
                        }
                    }

                    // B. Đánh dấu các đáp án sai mà người dùng chọn (chỉ khi câu trả lời chung là sai)
                    if (input.checked && !isCorrectOption && !isCorrect) {
                        optionElement.classList.remove('bg-blue-200', 'border-blue-400');
                        optionElement.classList.add('incorrect-answer', 'border-red-600', 'border-4');
                    }
                });

                // 4. Thêm tóm tắt kết quả vào modal
                const summaryItem = document.createElement('p');
                summaryItem.className = isCorrect ? 'text-green-700' : 'text-red-700';
                summaryItem.innerHTML = `
                    <span class="font-bold">Câu ${qNum} ${q.isMultiChoice ? '(Nhiều đáp án)' : ''}:</span> 
                    Bạn chọn: ${userSelectedStr}
                    - Đáp án đúng: ${correctAnswersStr}
                `;
                summaryDiv.appendChild(summaryItem);
            });

            // Hiển thị điểm số
            document.getElementById('score-display').textContent = `Điểm của bạn: ${score} / ${questions.length}`;
            
            // Cập nhật tiêu đề modal nếu hết giờ
            const resultTitle = document.querySelector('#result-modal h2');
            if (isTimeUp) {
                resultTitle.textContent = "Hết Giờ! Bài Thi Đã Được Nộp Tự Động";
                resultTitle.classList.remove('text-indigo-700');
                resultTitle.classList.add('text-red-700');
            } else {
                resultTitle.textContent = "Kết Quả Bài Thi";
                resultTitle.classList.remove('text-red-700');
                resultTitle.classList.add('text-indigo-700');
            }

            showModal();
        }

        /**
         * Hiển thị modal kết quả
         */
        function showModal() {
            const modal = document.getElementById('result-modal');
            modal.classList.remove('hidden');
        }

        /**
         * Ẩn modal kết quả
         */
        function hideModal() {
            const modal = document.getElementById('result-modal');
            modal.classList.add('hidden');
        }

        /**
         * Khởi tạo ứng dụng
         */
        document.addEventListener('DOMContentLoaded', () => {
            questions = parseQuizData(quizTxtContent);
            if (questions.length === 0) {
                document.getElementById('quiz-form').innerHTML = '<p class="text-center text-red-500">Không tìm thấy câu hỏi nào để hiển thị. Vui lòng kiểm tra console để biết chi tiết lỗi đọc file.</p>';
                document.getElementById('submit-btn').disabled = true;
                return;
            }
            renderQuiz();

            // Bắt đầu đồng hồ đếm ngược
            startTimer();

            // 1. Gắn sự kiện cho nút Nộp Bài chính (mở modal xác nhận)
            document.getElementById('submit-btn').addEventListener('click', showConfirmModal);

            // 2. Gắn sự kiện cho nút Xác nhận Nộp Bài (trong modal)
            document.getElementById('confirm-submit-btn').addEventListener('click', () => submitQuiz(false)); // Nộp thủ công
        });

    </script>
</body>
</html>