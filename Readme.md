# Laravel Zero to Ready

**Laravel Zero to Ready** is a Laravel package that automates the initial project setup. With a single command, it configures essential features like localization, API versioning, and exception handling, saving you hours of repetitive work.


## 🚀 Why This Package?

Every time I started a new Laravel project, I found myself doing the same initial setup—localization, API versioning, exception handling, stubs, and more. While not mandatory, these are things you always end up needing at some point.

Setting them up manually took me 1-2 hours every time. And being a typical programmer, my first thought was: *"Why not automate this?"* (even if the automation itself takes more time to build! 😂).

So here we are! I created **Laravel Zero to Ready**, a package that lets you set up all these essentials with a single command. No more wasting time—just run the setup and start coding! 🎉

A huge thanks to [mazimez's Laravel Hands-On repo](https://github.com/mazimez/laravel-hands-on), which helped me a lot in learning Laravel and coding this package. 🙌

## 📦 What's Included?

From the vast pool of possible setups, I've included the most essential ones (for now):

- 🌍 **Localization** (because supporting multiple languages is always a good idea!)
- 🔥 **Exception Handling** (so your API errors don't look like a mess)
- 🔄 **API Versioning** (because you never know when you'll need v2!)

## ⚡ Installation

To install this package in your Laravel project, follow these steps:

### 1️⃣ Require the Package

Run the following command to install the package:

```sh
composer require kakarot/laravel-initial-setup
```

### 2️⃣ Run the Setup Command

Once installed, simply run:

```sh
php artisan project:setup
```

And that's it! Your Laravel project is now pre-configured with localization, exception handling, and API versioning. 🎉

## 🛠️ Future Enhancements

This package is just the beginning! I plan to add more common setup features over time, like stubs, multiple migration at a time, and more. Stay tuned! 🚀

## 🤝 Contributing

Found a bug or have an idea for improvement? Feel free to open an issue or submit a pull request. Let's make Laravel project setup even smoother together! 💡

---

Happy Coding! 🚀

