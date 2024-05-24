from pyrogram import Client, filters
from pyrogram.types import *
from pyromod import listen
import asyncio
import requests
import shutil
import os



# Google AppScript deployment ID
GS_ID = "AKfycbyLoQ22vC7W3VmeW1Pdw28oWvwKoUl9eVtKvxNqxC-rqQpHmPLYagY1faW76-IaiaTu"
cam_ip = "192.168.90.4"

api_id = 2815879
api_hash = "53db8b2b2b8bd08854d1ce4b62a47c8a"
token = "7087122242:AAHoL5kerAIBorBSkrU4A6Z8NN5iWUT-a6c"
bot = Client("bellosguardo_bot", api_id=api_id, api_hash=api_hash, bot_token=token)

#keyboards
start_kb = InlineKeyboardMarkup(
    [
        [
            InlineKeyboardButton(
                "Controls",
                callback_data="controls_cb"
            ),
            InlineKeyboardButton(
                "Info",
                callback_data="info_cb"
            )
        ],
        [
            InlineKeyboardButton(
                "Capture",
                callback_data="capture_cb"
            )
        ]
    ]
)

controls_kb = InlineKeyboardMarkup(
    [
        [
            InlineKeyboardButton(
                "X",
                callback_data="set_cbx"
            ),
            InlineKeyboardButton(
                "Y",
                callback_data="set_cby"
            ),
            InlineKeyboardButton(
                "Z",
                callback_data="set_cbz"
            ),
        ],
        [
            InlineKeyboardButton(
                "Indietro",
                callback_data="start_cb"
            )
        ]
    ]
)

@bot.on_message(filters.command("start"))
async def start(client, message):
    await message.reply_text("Questo bot permette di controllare il progetto BelloSguardo, presentato dall'ISIT Bassi-Burgatti(Cento FE) allo SchoolMakerDay!!!", reply_markup=start_kb)
    
@bot.on_callback_query(filters.regex("start_cb"))
async def get_start(client, query):
    await start(client, query.message)
    await query.answer()


@bot.on_callback_query(filters.regex("info_cb"))
async def get_info(client, query):
    await bot.send_message(query.message.chat.id, "@Bello_Sguardo_bot è un semplice bot telegram che ti consente di interagire con BelloSguardo, Il progetto presentato allo SchoolMakerDay dall'istituto ISIT Bassi-Burgatti(Cento FE), da questo bot è possibile scattare immagini in tempo reale di ciò che BelloSguardo vede e modificare/visualizzare le sue coordinate di movimento, per capire meglio il funzionamento di questo bot e del resto del progetto, vai al [sito ufficiale di BelloSguardo](http://lab.isit100.fe.it:8085)")
    await start(client, query.message)
    await query.answer()



@bot.on_callback_query(filters.regex("capture_cb"))
async def capture_image(client, query):
    img = requests.get(f"http://{cam_ip}/capture", stream=True)
    if img.status_code == 200:
        with open("botimg.jpg",'wb') as f:
            shutil.copyfileobj(img.raw, f)
        await bot.send_photo(query.message.chat.id, "botimg.jpg") 
        os.remove("botimg.jpg")
    else:
        await bot.send_message(query.message.chat.id, "Impossibile recuperare l'immagine")
    await start(client, query.message)
    await query.answer()


@bot.on_callback_query(filters.regex("controls_cb"))
async def controls_handler(client, query):
    res = requests.get(f"https://script.google.com/macros/s/{GS_ID}/exec")
    if res.status_code != 200:
        await bot.send_message(query.message.chat.id, "Impossibile recuperare l'attuale configurazione, riprovare più tardi!!")
        return -1
    rdata = res.json()
    await bot.send_message(query.message.chat.id, f"Controlla BelloSguardo direttamente da questo bot impostando le sue coordinate: Attuali: X -> {rdata[0][0]} | Y -> {rdata[1][0]} | Z -> {rdata[2][0]}", reply_markup=controls_kb)
    await query.answer()


@bot.on_callback_query(filters.regex(r"set_cb\w"))
async def set_coordinate(client, query):
    coord = query.data[-1]
    while True:
        try:
            value = await bot.ask(query.message.chat.id, f"Nuovo valore coordinata {coord} (0-180):")
            value = int(value.text)
            if 0 <= value <= 180:
                break
            else:
                raise ValueError
        except:
            await bot.send_message(query.message.chat.id, "Valore non valido!! Riprovare")
    await bot.send_message(query.message.chat.id, "Sto inviando i nuovi dati...")
    g_data = {"coord": coord, "value": value}
    res = requests.post(f"https://script.google.com/macros/s/{GS_ID}/exec", data=g_data)
    if res.status_code != 200:
        await bot.send_message(query.message.chat.id, "Errore nell'invio dei dati, riprovare più tardi!!!!")
    await controls_handler(client, query)

bot.run()
