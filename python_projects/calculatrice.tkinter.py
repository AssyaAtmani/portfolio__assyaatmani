import tkinter as tk

class RoundedButton(tk.Canvas):
    def __init__(self, parent, text, radius, bg, fg, border_color, command=None):
        super().__init__(parent, borderwidth=0, highlightthickness=0, bg=parent["bg"], cursor="hand2")
        self.command = command
        self.bg = bg
        self.fg = fg
        self.border_color = border_color
        self.text = text
        self.radius = radius
        
        self.bind("<Configure>", self._draw)
        self.bind("<ButtonPress-1>", self._on_press)
        self.bind("<ButtonRelease-1>", self._on_release)

    def _draw(self, event=None):
        self.delete("all")
        w = self.winfo_width()
        h = self.winfo_height()
        r = self.radius
        self.create_rounded_rect(2, 2, w-2, h-2, r, fill=self.bg, outline=self.border_color, width=2)
        self.create_text(w/2, h/2, text=self.text, fill=self.fg, font=("Arial", 16, "bold", "italic"))
    def create_rounded_rect(self, x1, y1, x2, y2, r, **kwargs):
        points = [x1+r, y1, x1+r, y1, x2-r, y1, x2-r, y1, x2, y1, x2, y1+r, x2, y1+r, x2, y2-r, x2, y2-r, x2, y2, x2-r, y2, x2-r, y2, x1+r, y2, x1+r, y2, x1, y2, x1, y2-r, x1, y2-r, x1, y1+r, x1, y1+r, x1, y1]
        return self.create_polygon(points, **kwargs, smooth=True)
    def _on_press(self, event):
        self.configure(opacity=0.8) 
        if self.command:
            self.command()
    def _on_release(self, event):
        self._draw()

class CalculatriceTkinter:
    def __init__(self, root):
        self.root = root
        self.root.title("Calculatrice Tkinter - Real 15px Radius")
        self.root.geometry("340x460")
        self.root.resizable(False, False)
        self.root.configure(bg="#1c1c1e")
        self.border_color = "#7d4c54"
        self.ecran = tk.Entry(
            root, font=("Arial", 22, "bold"), bg="#2c2c2e", fg="#ffffff", 
            bd=0, highlightthickness=2, highlightbackground=self.border_color,
            highlightcolor=self.border_color, justify="right"
        )
        self.ecran.pack(pady=20, padx=20, fill="x")
        self.buttons_frame = tk.Frame(root, bg="#1c1c1e")
        self.buttons_frame.pack(expand=True, fill="both", padx=20, pady=(0, 20))
        for i in range(4):
            self.buttons_frame.rowconfigure(i, weight=1)
            self.buttons_frame.columnconfigure(i, weight=1)
        self.creer_boutons()
    def creer_boutons(self):
        boutons = {
            '7': (0, 0), '8': (0, 1), '9': (0, 2), '/': (0, 3),
            '4': (1, 0), '5': (1, 1), '6': (1, 2), '*': (1, 3),
            '1': (2, 0), '2': (2, 1), '3': (2, 2), '-': (2, 3),
            'C': (3, 0), '0': (3, 1), '=': (3, 2), '+': (3, 3),
        }
        for texte, position in boutons.items():
            bouton = RoundedButton(
                self.buttons_frame, 
                text=texte,
                radius=15,
                bg="#3a3a3c", 
                fg="#ffffff",
                border_color=self.border_color,
                command=lambda t=texte: self.gestion_bouton(t)
            )
            bouton.grid(row=position[0], column=position[1], sticky="nsew", padx=6, pady=6)
    def gestion_bouton(self, valeur):
        if valeur == 'C':
            self.ecran.delete(0, tk.END)
        elif valeur == '=':
            try:
                res = str(eval(self.ecran.get()))
                self.ecran.delete(0, tk.END)
                self.ecran.insert(tk.END, res)
            except Exception:
                self.ecran.delete(0, tk.END)
                self.ecran.insert(tk.END, "Error")
        else:
            self.ecran.insert(tk.END, valeur)
if __name__ == "__main__":
    root = tk.Tk()
    app = CalculatriceTkinter(root)
    root.mainloop()
