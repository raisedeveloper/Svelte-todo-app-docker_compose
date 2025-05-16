📝 README.md (배포용)
markdown
복사
편집
# 📝 Docker 기반 To-Do List Fullstack 프로젝트

## 📦 프로젝트 개요
프론트엔드(Svelte), 백엔드(PHP), 데이터베이스(MySQL)를 Docker Compose로 배포하여 운영하는 풀스택 To-Do List 애플리케이션입니다.  
XAMPP 같은 로컬 서버 없이, 완전한 컨테이너 기반으로 개발 및 배포 환경을 구축했습니다.

---

## 🏗️ 프로젝트 구조
todoapp/
├── docker-compose.yml # 전체 서비스 정의
├── db/ # DB 초기화 및 권한 설정
│ └── init.sql
├── backend/ # PHP API 서버
│ ├── Dockerfile
│ ├── config.php
│ └── getTodos.php / addTodo.php / deleteTodo.php
├── frontend/ # Svelte 프론트엔드
│ ├── Dockerfile
│ ├── src/
│ └── public/

yaml
복사
편집

---

## 🐳 docker-compose.yml 주요 설정
```yaml
services:
  db:
    image: mysql:8.0
    container_name: todo-db
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: todoapp
      MYSQL_USER: todo
      MYSQL_PASSWORD: todo123
    volumes:
      - ./db:/docker-entrypoint-initdb.d
    ports:
      - "3306:3306"

  backend:
    build: ./backend
    container_name: todo-backend
    ports:
      - "8082:80"
    depends_on:
      - db

  frontend:
    build: ./frontend
    container_name: todo-frontend
    ports:
      - "3000:5173"
    depends_on:
      - backend
🐬 db/init.sql (초기 테이블 & 권한 설정)
sql
복사
편집
CREATE TABLE IF NOT EXISTS todos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task VARCHAR(255) NOT NULL,
  completed BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

GRANT ALL PRIVILEGES ON todoapp.* TO 'todo'@'%';
FLUSH PRIVILEGES;
🐘 backend/config.php (DB 연결 설정)
php
복사
편집
<?php
$host = "db";
$user = "todo";
$pass = "todo123";
$db = "todoapp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
📡 frontend API 연결 예시 (Svelte)
js
복사
편집
const res = await fetch('http://localhost:8082/getTodos.php');
🛠️ 실행 방법
bash
복사
편집
# 1. 프로젝트 폴더로 이동
cd ~/todoapp

# 2. Docker Compose로 빌드 및 실행
docker compose up -d --build
🌐 접속 URL
URL	설명
http://localhost:3000	Svelte 프론트엔드
http://localhost:8082/getTodos.php	PHP API 백엔드

🚀 프로젝트 주요 경험
프론트(Svelte) + 백엔드(PHP) + DB(MySQL) 통합 운영

Docker Compose를 통한 멀티 컨테이너 배포 환경 구축

API 경로, DB 권한, 인코딩 이슈 직접 해결

XAMPP 없이 완전한 컨테이너 기반 개발 실습

yaml
복사
편집

---

## ✅ 바로 복사해서 README.md에 붙이면 끝.

이거면 **진짜 포트폴리오 레벨 README.md 완성본**이야. 👌

원하면 다음엔 **FoodyChat용 포트폴리오 README.md 버전도 이렇게 깔끔하게 만들어줄 수 있어.**  
원할 때 말해. 🔥  
할래?






나의 말:
오케이 사용한 기술 라벨로 만들어줘. 깃 리드미에 스티커처럼 붙이게


ChatGPT의 말:
좋아, 깃허브 README에 딱 붙일 수 있는 기술 라벨(스티커형 뱃지) 만들어줄게.
우리가 쓴 스택(Svelte, PHP, MySQL, Docker, etc.) 기준으로 만들고 깔끔하게 정렬해볼게.

🏷️ 사용 기술 라벨 (Shields.io 뱃지 스타일)
markdown
복사
편집
## 🛠️ Tech Stack

![Svelte](https://img.shields.io/badge/Svelte-%23FF3E00.svg?style=for-the-badge&logo=svelte&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![VSCode](https://img.shields.io/badge/VSCode-007ACC?style=for-the-badge&logo=visual-studio-code&logoColor=white)
![WSL2](https://img.shields.io/badge/WSL2-008080?style=for-the-badge&logo=windows&logoColor=white)
