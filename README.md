# `universal-react-v1.5-builder`

Это небольшое сочитание кода php и фреймворка react.

Философия данного проекта такова: тк, React в большенстве случаев является приложением для 1 страницы, это вызывает боль у бэкендеров(меня в частности).
Я решил что главное в react это сам js после компиляции, и тем самым, можно заранее написать весь неоходимый код на react, скомпилировать, и положить в папку сайта.

Основная идея, это заранее подготовить скрипты, страницы, и закинуть их в index.js с условием if(id,css,...) будет найдено, то запускается скрипт.

## Способ использования.
При создании страниц вы можете обротится к удобному сборщику.
Записывайте как в примерах данные, вводите команду npm run page_build
и у вас создастся несколько папок:
1-pages тут хранятся шаблоны страниц для вашего сайта, это лишь заготовки по этому выдолжны будете их оформить самостоятельно.
2-./routers/ есть 2 файла collection.php и controller.php
2.1-В collection.php оформляются все пути и вызовы контроллера, в этот файл вы можете не лезть если вам не нужно будет удалять старые url пути.
2.2-В conrtoller.php изначально будут только несколько контроллеров- PublicController, PrivateController, UsersController
Эти контроллеры вызываются по сокращенному названию в конфигурационном файле страниц: Public, Private, Users.
Вы так-же можете добавить свой контроллер вписав 
    class {Название}Controller extends CA {
    
    } 
И так-же сокращенно его вызывать.
Расширение CA это класс для внедрения различных элементов безопасности.
Внедрение безопасности проходит после создания страниц, тоесть после сборки.
Однако если вы захотите добавить вызов функции в шаблон то в router/shablon.php вы можете вписать соответствующий контроллер и, шаблон функции и, что в него помещать



# Getting Started with Create React App

This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

## Available Scripts

In the project directory, you can run:

### `npm start`

Runs the app in the development mode.\
Open [http://localhost:3000](http://localhost:3000) to view it in your browser.

The page will reload when you make changes.\
You may also see any lint errors in the console.

### `npm test`

Launches the test runner in the interactive watch mode.\
See the section about [running tests](https://facebook.github.io/create-react-app/docs/running-tests) for more information.

### `npm run build`

Builds the app for production to the `build` folder.\
It correctly bundles React in production mode and optimizes the build for the best performance.

The build is minified and the filenames include the hashes.\
Your app is ready to be deployed!

See the section about [deployment](https://facebook.github.io/create-react-app/docs/deployment) for more information.

### `npm run eject`

**Note: this is a one-way operation. Once you `eject`, you can't go back!**

If you aren't satisfied with the build tool and configuration choices, you can `eject` at any time. This command will remove the single build dependency from your project.

Instead, it will copy all the configuration files and the transitive dependencies (webpack, Babel, ESLint, etc) right into your project so you have full control over them. All of the commands except `eject` will still work, but they will point to the copied scripts so you can tweak them. At this point you're on your own.

You don't have to ever use `eject`. The curated feature set is suitable for small and middle deployments, and you shouldn't feel obligated to use this feature. However we understand that this tool wouldn't be useful if you couldn't customize it when you are ready for it.

## Learn More

You can learn more in the [Create React App documentation](https://facebook.github.io/create-react-app/docs/getting-started).

To learn React, check out the [React documentation](https://reactjs.org/).

### Code Splitting

This section has moved here: [https://facebook.github.io/create-react-app/docs/code-splitting](https://facebook.github.io/create-react-app/docs/code-splitting)

### Analyzing the Bundle Size

This section has moved here: [https://facebook.github.io/create-react-app/docs/analyzing-the-bundle-size](https://facebook.github.io/create-react-app/docs/analyzing-the-bundle-size)

### Making a Progressive Web App

This section has moved here: [https://facebook.github.io/create-react-app/docs/making-a-progressive-web-app](https://facebook.github.io/create-react-app/docs/making-a-progressive-web-app)

### Advanced Configuration

This section has moved here: [https://facebook.github.io/create-react-app/docs/advanced-configuration](https://facebook.github.io/create-react-app/docs/advanced-configuration)

### Deployment

This section has moved here: [https://facebook.github.io/create-react-app/docs/deployment](https://facebook.github.io/create-react-app/docs/deployment)

### `npm run build` fails to minify

This section has moved here: [https://facebook.github.io/create-react-app/docs/troubleshooting#npm-run-build-fails-to-minify](https://facebook.github.io/create-react-app/docs/troubleshooting#npm-run-build-fails-to-minify)
