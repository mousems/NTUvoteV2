## NTUVoteV2

這是一個電子投票系統，將使用於臺灣大學103學年第1學期學代會選舉，前身是 NTUVote，改用 Codeigniter Framework 重構，並增加了 API 、管理後台等方便選委會編輯選舉。

本系統由臺灣大學選委會外包 MouseMs 開發，並由台大開源社開發身份認證系統。

簡介之簡報請參考：http://www.slideshare.net/mousems/ntuvotev2
更技術的規格請參考：https://hackpad.com/NTUvoteV2-uK5hxqFocM0


本系統亦於 2014/11/17-18 進行假票真投六都市長。

#### 平版投票介面

![preview](https://dl.dropboxusercontent.com/s/5xth0ebcvb7hx0z/SC-VBm1E.png?dl=0)
![preview](https://dl.dropboxusercontent.com/s/66t2t1cwnwgqas7/SC-2Sr90.png?dl=0)
![preview](https://dl.dropboxusercontent.com/s/rgce9xtw2d8ljqd/SC-e57FI.png?dl=0)

#### 管理員介面

![preview](https://dl.dropboxusercontent.com/s/xgdfd0ffpx86y16/SC-GHrWJ.png?dl=0)

#### 票所後台

![preview](https://dl.dropboxusercontent.com/s/sfyas1b324ks5sj/SC-kK8Ij.png?dl=0)

## 投票流程


1. 同學們選擇一個最近的投票所
2. 持學生證，選務人員使用開源社 APP 進行身份確認
3. 身份認證通過
4. 開源社 APP 隨機將一組授權碼 push 給投票系統
5. 投票系統回答：請至第n號平版
6. 前往第n號平版
7. 按下開始按鈕，一一將每一票別完成，其間可略過不投。



## 名詞定義


* 投票所：station
	* 一場選舉有多個投票亭提供投票服務
	* 投票亭包含
		* n台平版（booth）
		* 開源社開發的身份認證系統（APP）
* 投票票種：ballot type
    * 一個投票項目（一張選票）就代表一個票種，例如「學生會長」
    * 有多個候選人
* 投票票別：ballot list
	* 一些票種的集合
	* 以台大選舉來說，代表投票人的一種身份別，例如「社會科學院大學部」
	* 「社會科學院大學部」可以投多種選票，因此票別會對應到一個系列的票種
* 授權碼：authcode
	* 投票時的辨識碼，在系統內用此碼進行投票
	* 發放隨機授權碼給投票人，即可達成匿名效果
	* 範例：1B-MZCROQXVS-VJK0MW2XB-761C0
	* 相關規格請參考 hackpad
	
## 架設

https://github.com/mousems/NTUVoteV2_install

## 開票

若使用上述方法架設，選票會儲存於 /var/log/NTUticket

請執行 /var/log/NTUticket/Result.sh
開票原始碼：https://github.com/mousems/NTUVoteV2_install/blob/master/Result.sh
如：cd /var/log/NTUticket && sh Result.sh

便會顯示投票結果。


## License

MIT License (MIT)
Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
http://opensource.org/licenses/MIT

* /application/controllers/*
* /application/views/*
* /application/models/*
* /application/libraries/*

