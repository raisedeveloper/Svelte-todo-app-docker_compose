# 📝 Docker + Jenkins 기반 To-Do List Fullstack 자동배포 프로젝트

## 📦 프로젝트 개요
프론트엔드(Svelte), 백엔드(PHP), 데이터베이스(MySQL)를 Docker Compose로 통합 배포하고,  
Jenkins를 활용해 **GitHub에서 변경사항(Push)이 발생하면 자동으로 빌드 & 배포가 트리거되는 CI/CD 파이프라인**을 구축한 풀스택 To-Do List 애플리케이션입니다.  

XAMPP 같은 로컬 서버 없이, 완전한 컨테이너 기반 개발/운영 환경을 구현했으며,  
Jenkins를 통한 자동화로 **Push 기반의 빌드 & 배포 자동화 환경(DevOps)를 완성**했습니다.  

---

## 🛠️ Tech Stack

<table>
  <tr>
    <td><img src="https://img.shields.io/badge/Svelte-%23FF3E00.svg?style=for-the-badge&logo=svelte&logoColor=white" /></td>
    <td><img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" /></td>
  </tr>
  <tr>
    <td><img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" /></td>
    <td><img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" /></td>
  </tr>
  <tr>
    <td><img src="https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white" /></td>
    <td><img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" /></td>
  </tr>
  <tr>
    <td><img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" /></td>
    <td><img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" /></td>
  </tr>
  <tr>
    <td><img src="https://img.shields.io/badge/VSCode-007ACC?style=for-the-badge&logo=visual-studio-code&logoColor=white" /></td>
    <td><img src="https://img.shields.io/badge/WSL2-008080?style=for-the-badge&logo=windows&logoColor=white" /></td>
  </tr>
</table>

---

## 🚀 CI/CD with Jenkins

<p align="center">
  <img src="https://www.jenkins.io/images/logos/jenkins/jenkins.png" width="120" alt="Jenkins logo">
</p>  

### 📦 구축 스택  
- GitHub Webhook + ngrok를 이용한 Jenkins 트리거  
- Jenkins Freestyle Job을 통한 빌드 & 배포 자동화  
- Git SCM Polling으로 변경사항 감지 후 빌드 실행  
- Docker Compose 기반 프론트엔드(Svelte), 백엔드(PHP), DB(MySQL) 통합 배포  

> GitHub에서 코드 Push 시, Webhook을 통해 Jenkins가 트리거되어  
> 변경된 소스를 기반으로 Docker 이미지 빌드 및 서비스 재배포까지 자동화된 파이프라인을 구축했습니다.  

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

---

## 🐳 docker-compose.yml 주요 설정  
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

---

## 🐬 db/init.sql (초기 테이블 & 권한 설정)  
```sql
CREATE TABLE IF NOT EXISTS todos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  task VARCHAR(255) NOT NULL,
  completed BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

GRANT ALL PRIVILEGES ON todoapp.* TO 'todo'@'%';
FLUSH PRIVILEGES;

---

🐘 backend/config.php (DB 연결 설정)
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

---

📡 frontend API 연결 예시 (Svelte)  
const res = await fetch('http://localhost:8082/getTodos.php');

---

🛠️ 실행 방법  
# 1. 프로젝트 폴더로 이동  
cd ~/todoapp  

# 2. Docker Compose로 빌드 및 실행  
docker compose up -d --build  
  
---

🌐 접속 URL  
http://localhost:3000	- Svelte 프론트엔드  
http://localhost:8082/getTodos.php - PHP API 백엔드  

---

🚀 프로젝트 주요 경험  
프론트(Svelte) + 백엔드(PHP) + DB(MySQL) 통합 운영  

Docker Compose를 통한 멀티 컨테이너 배포 환경 구축  

API 경로, DB 권한, 인코딩 이슈 직접 해결  

XAMPP 없이 완전한 컨테이너 기반 개발 실습  
